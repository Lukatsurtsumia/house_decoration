const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const navToggle = document.querySelector('[data-nav-toggle]');
const navMenu = document.querySelector('[data-nav-menu]');
const navBackdrop = document.querySelector('[data-nav-backdrop]');
const navIconOpen = document.querySelector('[data-nav-icon-open]');
const navIconClose = document.querySelector('[data-nav-icon-close]');

if (navToggle && navMenu) {
    const closeMenu = () => {
        navMenu.classList.add('-translate-y-2', 'opacity-0');
        navBackdrop?.classList.add('opacity-0');
        navToggle.setAttribute('aria-expanded', 'false');
        navIconOpen?.classList.remove('hidden');
        navIconClose?.classList.add('hidden');

        window.setTimeout(() => {
            navMenu.hidden = true;
            if (navBackdrop) navBackdrop.hidden = true;
        }, 200);
    };

    const openMenu = () => {
        navMenu.hidden = false;
        if (navBackdrop) navBackdrop.hidden = false;
        navToggle.setAttribute('aria-expanded', 'true');
        navIconOpen?.classList.add('hidden');
        navIconClose?.classList.remove('hidden');

        requestAnimationFrame(() => {
            navMenu.classList.remove('-translate-y-2', 'opacity-0');
            navBackdrop?.classList.remove('opacity-0');
        });
    };

    navToggle.addEventListener('click', () => {
        if (navMenu.hidden) {
            openMenu();
        } else {
            closeMenu();
        }
    });

    navMenu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', closeMenu);
    });

    navBackdrop?.addEventListener('click', closeMenu);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !navMenu.hidden) {
            closeMenu();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024 && !navMenu.hidden) {
            closeMenu();
        }
    });
}

const navbar = document.querySelector('[data-navbar]');

if (navbar) {
    const updateNavbarElevation = () => {
        navbar.classList.toggle('shadow-sm', window.scrollY > 8);
    };

    updateNavbarElevation();
    window.addEventListener('scroll', updateNavbarElevation, { passive: true });
}

// Underline the nav link of the section currently in view.
const navLinks = Array.from(document.querySelectorAll('[data-nav-link]'));

if (navLinks.length && 'IntersectionObserver' in window) {
    const linksBySection = new Map(navLinks.map((link) => [link.getAttribute('href').slice(1), link]));

    const sectionObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                navLinks.forEach((link) => link.removeAttribute('aria-current'));
                linksBySection.get(entry.target.id)?.setAttribute('aria-current', 'true');
            });
        },
        { rootMargin: '-45% 0px -50% 0px' },
    );

    linksBySection.forEach((link, id) => {
        const section = document.getElementById(id);
        if (section) sectionObserver.observe(section);
    });
}

// Hero slideshow: the progress bar under the active thumbnail drives autoplay.
const heroSlideshow = document.querySelector('[data-hero-slideshow]');

if (heroSlideshow) {
    const slides = Array.from(heroSlideshow.querySelectorAll('[data-slide]'));
    const thumbs = Array.from(heroSlideshow.querySelectorAll('[data-slide-thumb]'));
    const bars = thumbs.map((thumb) => thumb.querySelector('.thumb-progress'));
    const caption = heroSlideshow.querySelector('[data-slide-caption]');
    const counter = heroSlideshow.querySelector('[data-slide-counter]');
    const autoplay = !prefersReducedMotion && slides.length > 1;

    let current = 0;

    const restartProgress = () => {
        bars.forEach((bar) => bar?.classList.remove('is-running'));

        const bar = bars[current];
        if (!autoplay || !bar) return;

        void bar.offsetWidth; // restart the CSS animation
        bar.classList.add('is-running');
    };

    const setThumb = (thumb, isActive) => {
        if (!thumb) return;
        thumb.classList.toggle('opacity-100', isActive);
        thumb.classList.toggle('opacity-55', !isActive);
        thumb.setAttribute('aria-current', isActive ? 'true' : 'false');
    };

    const goTo = (index) => {
        const next = (index + slides.length) % slides.length;

        if (next !== current) {
            slides[current].classList.add('opacity-0');
            slides[current].classList.remove('is-active');
            slides[current].setAttribute('aria-hidden', 'true');
            setThumb(thumbs[current], false);

            slides[next].classList.remove('opacity-0');
            slides[next].classList.add('is-active');
            slides[next].setAttribute('aria-hidden', 'false');
            setThumb(thumbs[next], true);

            if (caption) caption.textContent = slides[next].dataset.caption ?? '';
            if (counter) counter.textContent = String(next + 1).padStart(2, '0');

            current = next;
        }

        restartProgress();
    };

    const pause = () => heroSlideshow.classList.add('is-paused');
    const resume = () => heroSlideshow.classList.remove('is-paused');

    bars.forEach((bar) => bar?.addEventListener('animationend', () => goTo(current + 1)));
    thumbs.forEach((thumb, index) => thumb.addEventListener('click', () => goTo(index)));

    heroSlideshow.addEventListener('mouseenter', pause);
    heroSlideshow.addEventListener('mouseleave', resume);
    heroSlideshow.addEventListener('focusin', pause);
    heroSlideshow.addEventListener('focusout', resume);
    document.addEventListener('visibilitychange', () => (document.hidden ? pause() : resume()));

    heroSlideshow.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') goTo(current - 1);
        if (event.key === 'ArrowRight') goTo(current + 1);
    });

    let touchStartX = 0;

    heroSlideshow.addEventListener(
        'touchstart',
        (event) => {
            touchStartX = event.changedTouches[0].clientX;
        },
        { passive: true },
    );

    heroSlideshow.addEventListener(
        'touchend',
        (event) => {
            const delta = event.changedTouches[0].clientX - touchStartX;
            if (Math.abs(delta) > 40) goTo(current + (delta < 0 ? 1 : -1));
        },
        { passive: true },
    );

    // Fetch the remaining photos once the page has loaded, so no slide appears before its image.
    window.addEventListener('load', () => {
        slides.forEach((slide) => {
            const image = slide.querySelector('img');
            if (image) image.loading = 'eager';
        });
    });

    restartProgress();
}

// Calculator: rooms are measured by length x width; the price follows the finish, wall type and add-ons.
const calculator = document.querySelector('[data-calculator]');

if (calculator) {
    const { currency, minimum, finishes, walls, extras, perimeter, dimensions, maxRooms, labels } = JSON.parse(
        calculator.dataset.calculatorConfig,
    );
    const finishKeys = Object.keys(finishes);
    const wallKeys = Object.keys(walls);
    const extraKeys = Object.keys(extras);
    const perimeterKeys = Object.keys(perimeter);

    const roomsBox = calculator.querySelector('[data-calc-rooms]');
    const addRoomButton = calculator.querySelector('[data-calc-add]');
    const plan = calculator.querySelector('[data-calc-plan]');
    const areaOutput = calculator.querySelector('[data-calc-area]');
    const perimeterOutput = calculator.querySelector('[data-calc-perimeter-length]');
    const finishInputs = Array.from(calculator.querySelectorAll('[data-calc-finish]'));
    const wallInputs = Array.from(calculator.querySelectorAll('[data-calc-wall]'));
    const perimeterInputs = Array.from(calculator.querySelectorAll('[data-calc-perimeter]'));
    const linesBox = calculator.querySelector('[data-calc-lines]');
    const totalOutput = calculator.querySelector('[data-calc-total]');
    const headTotal = calculator.querySelector('[data-calc-head-total]');
    const totalAnnouncer = calculator.querySelector('[data-calc-total-sr]');

    const dimensionInputs = {
        length: calculator.querySelector('[data-calc-dimension="length"]'),
        width: calculator.querySelector('[data-calc-dimension="width"]'),
    };
    const dimensionRanges = {
        length: calculator.querySelector('[data-calc-dimension-range="length"]'),
        width: calculator.querySelector('[data-calc-dimension-range="width"]'),
    };

    const money = new Intl.NumberFormat('ka-GE', { maximumFractionDigits: 2 });
    const number = new Intl.NumberFormat('ka-GE', { maximumFractionDigits: 2 });
    const formatMoney = (value) => `${money.format(value)} ${currency}`;

    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
    const round2 = (value) => Math.round(value * 100) / 100;

    const element = (tag, className, content) => {
        const node = document.createElement(tag);
        if (className) node.className = className;
        if (content !== undefined) node.textContent = content;
        return node;
    };

    const svgElement = (tag, attributes = {}, content) => {
        const node = document.createElementNS('http://www.w3.org/2000/svg', tag);
        Object.entries(attributes).forEach(([name, value]) => node.setAttribute(name, value));
        if (content !== undefined) node.textContent = content;
        return node;
    };

    const createRoom = () => ({
        length: dimensions.length,
        width: dimensions.width,
        finish: finishKeys[0],
        wall: wallKeys[0],
        extras: Object.fromEntries(extraKeys.map((key) => [key, 0])),
        perimeter: Object.fromEntries(perimeterKeys.map((key) => [key, false])),
    });

    let rooms = [createRoom()];
    let active = 0;

    const measure = (room) => ({
        area: round2(room.length * room.width),
        edge: round2(2 * (room.length + room.width)),
    });

    const quoteRoom = (room) => {
        const { area, edge } = measure(room);
        const finish = finishes[room.finish];
        const wall = walls[room.wall];
        const ceilingCost = area * finish.price;
        const lines = [
            {
                label: `${labels.ceiling} (${finish.name})`,
                detail: ceilingCost < minimum ? labels.minimum : `${number.format(area)} ${finish.unit} × ${formatMoney(finish.price)}`,
                amount: Math.max(ceilingCost, minimum),
            },
        ];

        // Tile and porcelain walls add a fixing charge along the whole perimeter.
        if (wall.price > 0) {
            lines.push({ label: wall.name, detail: `${number.format(edge)} ${wall.unit} × ${formatMoney(wall.price)}`, amount: edge * wall.price });
        }

        extraKeys.forEach((key) => {
            const quantity = room.extras[key];
            if (quantity <= 0) return;

            lines.push({
                label: extras[key].name,
                detail: `${number.format(quantity)} ${extras[key].unit} × ${formatMoney(extras[key].price)}`,
                amount: quantity * extras[key].price,
            });
        });

        perimeterKeys.forEach((key) => {
            if (!room.perimeter[key]) return;

            lines.push({
                label: perimeter[key].name,
                detail: `${number.format(edge)} ${perimeter[key].unit} × ${formatMoney(perimeter[key].price)}`,
                amount: edge * perimeter[key].price,
            });
        });

        return { lines, total: lines.reduce((sum, line) => sum + line.amount, 0) };
    };

    const renderPlan = (room) => {
        const width = 320;
        const height = 240;
        const padding = 44;
        const scale = Math.min((width - padding * 2) / room.length, (height - padding * 2) / room.width);
        const w = room.length * scale;
        const h = room.width * scale;
        const x = (width - w) / 2;
        const y = (height - h) / 2;
        const { area } = measure(room);

        const grid = svgElement('pattern', { id: 'plan-grid', width: 16, height: 16, patternUnits: 'userSpaceOnUse' });
        grid.append(svgElement('path', { d: 'M16 0H0V16', fill: 'none', stroke: '#e2e5e0', 'stroke-width': 1 }));
        const defs = svgElement('defs');
        defs.append(grid);

        const nodes = [
            defs,
            svgElement('rect', { width, height, fill: 'url(#plan-grid)' }),
            svgElement('rect', { x, y, width: w, height: h, rx: 2, fill: '#fff', stroke: '#17191b', 'stroke-width': 2.5 }),
        ];

        if (perimeterKeys.some((key) => room.perimeter[key])) {
            nodes.push(
                svgElement('rect', {
                    x: x + 5,
                    y: y + 5,
                    width: Math.max(0, w - 10),
                    height: Math.max(0, h - 10),
                    fill: 'none',
                    stroke: '#0f8a5f',
                    'stroke-width': 1.5,
                    'stroke-dasharray': '4 3',
                }),
            );
        }

        if (room.extras.curtain > 0) {
            const niche = Math.min(w - 16, room.extras.curtain * scale);
            nodes.push(
                svgElement('line', {
                    x1: x + (w - niche) / 2,
                    y1: y + 10,
                    x2: x + (w + niche) / 2,
                    y2: y + 10,
                    stroke: '#0f8a5f',
                    'stroke-width': 4,
                    'stroke-linecap': 'round',
                }),
            );
        }

        const lights = Math.min(room.extras.lights ?? 0, 36);

        if (lights > 0) {
            const columns = Math.max(1, Math.round(Math.sqrt((lights * w) / h)));
            const rows = Math.ceil(lights / columns);

            for (let i = 0; i < lights; i++) {
                const row = Math.floor(i / columns);
                const inRow = row === rows - 1 ? lights - row * columns : columns;
                const cx = x + (w / inRow) * ((i % columns) + 0.5);
                const cy = y + (h / rows) * (row + 0.5);

                nodes.push(
                    svgElement('circle', { cx, cy, r: 9, fill: '#f5b841', 'fill-opacity': 0.25 }),
                    svgElement('circle', { cx, cy, r: 3.5, fill: '#f5b841', stroke: '#b7862a', 'stroke-width': 1 }),
                );
            }
        }

        const pipes = Math.min(room.extras.pipes ?? 0, 8);

        for (let i = 0; i < pipes; i++) {
            nodes.push(svgElement('circle', { cx: x + w - 12 - i * 11, cy: y + h - 12, r: 3.5, fill: '#fff', stroke: '#3a3f44', 'stroke-width': 1.5 }));
        }

        const tick = (x1, y1, x2, y2) => svgElement('line', { x1, y1, x2, y2, stroke: '#676d73', 'stroke-width': 1 });
        const areaLabel = svgElement('text', { x: x + w / 2, y: y + h / 2, 'text-anchor': 'middle', class: 'plan-area' }, `${number.format(area)} ${labels.sqm}`);

        nodes.push(
            tick(x, y - 16, x + w, y - 16),
            tick(x, y - 20, x, y - 12),
            tick(x + w, y - 20, x + w, y - 12),
            svgElement('text', { x: x + w / 2, y: y - 22, 'text-anchor': 'middle', class: 'plan-label' }, `${number.format(room.length)} ${labels.meter}`),
            tick(x - 16, y, x - 16, y + h),
            tick(x - 20, y, x - 12, y),
            tick(x - 20, y + h, x - 12, y + h),
            svgElement(
                'text',
                { x: x - 22, y: y + h / 2, 'text-anchor': 'middle', transform: `rotate(-90 ${x - 22} ${y + h / 2})`, class: 'plan-label' },
                `${number.format(room.width)} ${labels.meter}`,
            ),
            areaLabel,
        );

        plan.replaceChildren(...nodes);
        fitAreaLabel(areaLabel, x, y, w, h);
    };

    // Keep the area label inside the drawn room: shrink it when it is too wide, and turn it
    // along the long side of tall, narrow rooms.
    const fitAreaLabel = (label, x, y, w, h) => {
        const padding = 10;
        const largest = 24;

        label.style.fontSize = `${largest}px`;
        const length = label.getComputedTextLength();
        const vertical = length > w - padding * 2 && h > w;
        const along = (vertical ? h : w) - padding * 2;
        const across = (vertical ? w : h) - padding;
        const size = Math.max(9, Math.min(largest, (largest * along) / length, across * 0.75));

        label.style.fontSize = `${size}px`;
        label.setAttribute('y', y + h / 2 + size * 0.35);

        if (vertical) {
            label.setAttribute('transform', `rotate(-90 ${x + w / 2} ${y + h / 2})`);
        }
    };

    const renderRooms = () => {
        const items = rooms.map((room, index) => {
            const isActive = index === active;
            const wrapper = element(
                'div',
                isActive
                    ? 'flex shrink-0 items-center rounded-lg border border-ink bg-ink text-white'
                    : 'flex shrink-0 items-center rounded-lg border border-line bg-white text-ink-soft hover:border-ink/30',
            );

            const select = element('button', 'px-3 py-1.5 text-sm font-semibold whitespace-nowrap tabular-nums', `${labels.room} ${index + 1}`);
            // Phones show the name only, so a chip keeps its width while the sizes change.
            select.append(element('span', 'hidden sm:inline', ` · ${number.format(measure(room).area)} ${labels.sqm}`));
            select.type = 'button';
            select.dataset.calcRoom = String(index);
            select.setAttribute('aria-pressed', String(isActive));
            wrapper.append(select);

            if (rooms.length > 1) {
                const remove = element('button', isActive ? 'mr-1 rounded-md px-1.5 py-0.5 text-white/60 hover:text-white' : 'mr-1 rounded-md px-1.5 py-0.5 text-muted hover:text-ink', '×');
                remove.type = 'button';
                remove.dataset.calcRemove = String(index);
                remove.setAttribute('aria-label', `${labels.remove_room} ${index + 1}`);
                wrapper.append(remove);
            }

            return wrapper;
        });

        roomsBox.replaceChildren(...items);
        addRoomButton.hidden = rooms.length >= maxRooms;
        revealActiveRoom();
    };

    // On phones the chips scroll sideways: keep the active one fully in view, clear of the faded edge.
    const revealActiveRoom = () => {
        const chip = roomsBox.children[active];
        if (!chip || roomsBox.scrollWidth <= roomsBox.clientWidth) return;

        const box = roomsBox.getBoundingClientRect();
        const rect = chip.getBoundingClientRect();
        const inset = parseFloat(getComputedStyle(roomsBox).paddingLeft);
        const hiddenLeft = box.left + inset - rect.left;
        const hiddenRight = rect.right - (box.right - inset);

        // A chip wider than the view lines up with its start.
        if (hiddenLeft > 0 || rect.width > box.width - inset * 2) {
            roomsBox.scrollLeft -= hiddenLeft;
        } else if (hiddenRight > 0) {
            roomsBox.scrollLeft += hiddenRight;
        }
    };

    const fillRange = (range) => {
        const min = Number(range.min);
        const max = Number(range.max);
        range.style.setProperty('--fill', `${((clamp(Number(range.value), min, max) - min) / (max - min)) * 100}%`);
    };

    const syncInputs = () => {
        const room = rooms[active];
        const { area, edge } = measure(room);

        Object.keys(dimensionInputs).forEach((dimension) => {
            if (document.activeElement !== dimensionInputs[dimension]) dimensionInputs[dimension].value = String(room[dimension]);
            dimensionRanges[dimension].value = String(Math.min(room[dimension], dimensions.max));
            fillRange(dimensionRanges[dimension]);
        });

        areaOutput.textContent = `${number.format(area)} ${labels.sqm}`;
        perimeterOutput.textContent = `${number.format(edge)} ${labels.meter}`;

        finishInputs.forEach((input) => {
            input.checked = input.value === room.finish;
        });
        wallInputs.forEach((input) => {
            input.checked = input.value === room.wall;
        });
        perimeterInputs.forEach((input) => {
            input.checked = room.perimeter[input.dataset.calcPerimeter];
        });

        extraKeys.forEach((key) => {
            const input = calculator.querySelector(`[data-calc-extra="${key}"]`);
            const decrease = calculator.querySelector(`[data-calc-step="-1"][data-key="${key}"]`);

            if (input && document.activeElement !== input) input.value = String(room.extras[key]);
            if (decrease) decrease.disabled = room.extras[key] <= 0;
        });

        renderPlan(room);
    };

    let shownTotal = 0;
    let totalFrame = null;
    let hasRendered = false;

    const showTotal = (total) => {
        cancelAnimationFrame(totalFrame);

        if (prefersReducedMotion || !hasRendered) {
            shownTotal = total;
            totalOutput.textContent = formatMoney(total);
            return;
        }

        const from = shownTotal;
        const startedAt = performance.now();

        const step = (now) => {
            const progress = Math.min(1, (now - startedAt) / 400);
            shownTotal = from + (total - from) * (1 - (1 - progress) ** 3);
            totalOutput.textContent = formatMoney(progress < 1 ? Math.round(shownTotal) : total);

            if (progress < 1) totalFrame = requestAnimationFrame(step);
        };

        totalFrame = requestAnimationFrame(step);
    };

    const renderSummary = () => {
        const quotes = rooms.map(quoteRoom);

        linesBox.replaceChildren(
            ...quotes.map((quote, index) => {
                const room = rooms[index];
                const block = element('div', 'border-b border-white/10 pb-4 last:border-0 last:pb-0');
                const head = element('div', 'flex items-baseline justify-between gap-4');

                head.append(
                    element('p', 'font-semibold', `${labels.room} ${index + 1} · ${number.format(room.length)} × ${number.format(room.width)} ${labels.meter}`),
                    element('p', 'font-semibold whitespace-nowrap tabular-nums', formatMoney(quote.total)),
                );

                const list = element('ul', 'mt-2 space-y-1.5 text-sm text-white/70');

                quote.lines.forEach((line) => {
                    const item = element('li', 'flex items-baseline justify-between gap-4');
                    const description = element('span', 'min-w-0');

                    description.append(line.label, element('span', 'text-white/40', ` · ${line.detail}`));
                    item.append(description, element('span', 'whitespace-nowrap tabular-nums', formatMoney(line.amount)));
                    list.append(item);
                });

                block.append(head, list);

                return block;
            }),
        );

        const total = quotes.reduce((sum, quote) => sum + quote.total, 0);

        showTotal(total);
        headTotal.textContent = formatMoney(total);
        totalAnnouncer.textContent = formatMoney(total);
        hasRendered = true;
    };

    const update = () => {
        renderRooms();
        syncInputs();
        renderSummary();
    };

    // renderRooms has already scrolled the chip into view, so focusing must not scroll again.
    const focusRoom = () => roomsBox.querySelector(`[data-calc-room="${active}"]`)?.focus({ preventScroll: true });

    Object.entries(dimensionInputs).forEach(([dimension, input]) => {
        input.addEventListener('input', () => {
            const value = parseFloat(input.value);

            // Wait until the typed value is a usable size before recalculating.
            if (!Number.isFinite(value) || value < dimensions.min) return;

            rooms[active][dimension] = round2(Math.min(value, dimensions.input_max));
            update();
        });

        input.addEventListener('change', () => {
            const value = parseFloat(input.value);

            rooms[active][dimension] = Number.isFinite(value) ? round2(clamp(value, dimensions.min, dimensions.input_max)) : dimensions[dimension];
            update();
            input.value = String(rooms[active][dimension]);
        });
    });

    Object.entries(dimensionRanges).forEach(([dimension, range]) => {
        range.addEventListener('input', () => {
            rooms[active][dimension] = Number(range.value);
            update();
        });
    });

    finishInputs.forEach((input) => {
        input.addEventListener('change', () => {
            rooms[active].finish = input.value;
            update();
        });
    });

    wallInputs.forEach((input) => {
        input.addEventListener('change', () => {
            rooms[active].wall = input.value;
            update();
        });
    });

    perimeterInputs.forEach((input) => {
        input.addEventListener('change', () => {
            rooms[active].perimeter[input.dataset.calcPerimeter] = input.checked;
            update();
        });
    });

    calculator.addEventListener('input', (event) => {
        const input = event.target.closest('[data-calc-extra]');
        if (!input) return;

        const value = parseFloat(input.value);
        if (!Number.isFinite(value)) return;

        rooms[active].extras[input.dataset.calcExtra] = round2(clamp(value, 0, 999));
        update();
    });

    calculator.addEventListener('change', (event) => {
        const input = event.target.closest('[data-calc-extra]');
        if (input) input.value = String(rooms[active].extras[input.dataset.calcExtra]);
    });

    calculator.addEventListener('click', (event) => {
        const stepButton = event.target.closest('[data-calc-step]');
        const roomButton = event.target.closest('[data-calc-room]');
        const removeButton = event.target.closest('[data-calc-remove]');
        const addButton = event.target.closest('[data-calc-add]');

        if (stepButton) {
            const key = stepButton.dataset.key;
            const next = rooms[active].extras[key] + Number(stepButton.dataset.calcStep) * (extras[key].step ?? 1);

            rooms[active].extras[key] = round2(clamp(next, 0, 999));
            update();
        } else if (roomButton) {
            active = Number(roomButton.dataset.calcRoom);
            update();
            focusRoom();
        } else if (removeButton) {
            const index = Number(removeButton.dataset.calcRemove);

            rooms.splice(index, 1);
            if (index < active || active >= rooms.length) active = Math.max(0, active - 1);
            update();
            focusRoom();
        } else if (addButton) {
            rooms.push(createRoom());
            active = rooms.length - 1;
            update();
            focusRoom();
        }
    });

    // "Download PDF" posts the rooms as they are now; the server prices them again from config.
    const pdfForm = calculator.querySelector('[data-calc-pdf-form]');

    pdfForm?.addEventListener('submit', () => {
        pdfForm.querySelector('[data-calc-pdf-rooms]').value = JSON.stringify(
            rooms.map(({ length, width, finish, wall, extras, perimeter }) => ({ length, width, finish, wall, extras, perimeter })),
        );
    });

    // Service cards open the calculator with a matching example in the current room.
    document.querySelectorAll('[data-calc-preset]').forEach((link) => {
        link.addEventListener('click', () => {
            const preset = JSON.parse(link.dataset.calcPreset || '{}');
            const room = rooms[active];

            Object.entries(preset).forEach(([key, value]) => {
                if (key === 'length' || key === 'width') room[key] = value;
                if (key === 'finish' && finishes[value]) room.finish = value;
                if (key === 'wall' && walls[value]) room.wall = value;
                if (key in extras) room.extras[key] = Math.max(room.extras[key], value);
                if (key in perimeter) room.perimeter[key] = Boolean(value);
            });

            update();

            calculator.removeAttribute('data-calc-flash');
            window.setTimeout(() => calculator.setAttribute('data-calc-flash', ''), 500);
        });
    });

    update();

    // The area label is measured to fit the room, so measure again once the web fonts have loaded.
    document.fonts?.ready.then(() => renderPlan(rooms[active]));
}

const mapElement = document.querySelector('[data-map]');

if (mapElement) {
    const initMap = async () => {
        const [leaflet] = await Promise.all([import('leaflet'), import('leaflet/dist/leaflet.css')]);
        const L = leaflet.default ?? leaflet;
        const { cities, radius_km: radiusKm } = JSON.parse(mapElement.dataset.mapConfig);

        const map = L.map(mapElement, { scrollWheelZoom: false, zoomSnap: 0.25 });

        map.attributionControl.setPrefix('<a href="https://leafletjs.com">Leaflet</a>');

        // Standard OpenStreetMap tiles label places in Georgia in Georgian.
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        }).addTo(map);

        const mainCity = cities.find((city) => city.main) ?? cities[0];

        L.circle([mainCity.lat, mainCity.lng], {
            radius: radiusKm * 1000,
            color: '#0f8a5f',
            weight: 1.5,
            dashArray: '6 6',
            fillColor: '#0f8a5f',
            fillOpacity: 0.08,
        }).addTo(map);

        cities.forEach((city) => {
            const size = city.main ? 20 : 16;
            const icon = L.divIcon({
                className: '',
                html: `<span class="area-pin${city.main ? ' area-pin--main' : ''}"></span>`,
                iconSize: [size, size],
                iconAnchor: [size / 2, size / 2],
            });

            L.marker([city.lat, city.lng], { icon, title: city.name, keyboard: false })
                .addTo(map)
                .bindTooltip(city.name, { permanent: true, direction: 'right', offset: [10, 0], className: 'area-label' });
        });

        // Frame the service circle only, so labels outside the area stay out of view.
        map.fitBounds(L.latLng(mainCity.lat, mainCity.lng).toBounds(radiusKm * 2000), { padding: [12, 12] });

        // Let the page scroll past the map until someone actually interacts with it.
        map.once('focus click', () => map.scrollWheelZoom.enable());
    };

    if ('IntersectionObserver' in window) {
        const mapObserver = new IntersectionObserver(
            ([entry]) => {
                if (!entry.isIntersecting) return;

                mapObserver.disconnect();
                initMap();
            },
            { rootMargin: '400px 0px' },
        );

        mapObserver.observe(mapElement);
    } else {
        initMap();
    }
}

const revealTargets = document.querySelectorAll('[data-reveal]');

if (revealTargets.length && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-in');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -40px 0px' },
    );

    revealTargets.forEach((el) => observer.observe(el));
} else {
    revealTargets.forEach((el) => el.classList.add('is-in'));
}
