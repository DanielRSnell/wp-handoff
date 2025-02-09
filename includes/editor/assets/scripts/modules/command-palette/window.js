import { extractComponents } from './utils.js';

export class CommandPaletteWindow {
  constructor() {
    this.isOpen = false;
    this.viewMode = 'list';
    this.selectedIndex = 0;
    this.components = [];
    this.filteredComponents = [];
    this.createElements();
    this.bindEvents();
  }

  createElements() {
    this.overlay = document.createElement('div');
    this.overlay.className = 'command-overlay';

    this.palette = document.createElement('div');
    this.palette.className = 'command-palette';

    const shortcutText = navigator.platform.toLowerCase().includes('mac') ? '⌘K' : 'Ctrl+K';

    this.palette.innerHTML = `
      <div class="command-palette__header">
        <div class="command-palette__search-wrapper">
          <svg class="command-palette__search-icon" viewBox="0 0 24 24">
            <path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39zM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7z"/>
          </svg>
          <input class="command-palette__search" type="text" placeholder="Search components... (${shortcutText})" />
        </div>
        <div class="command-palette__view-toggle">
          <button class="command-palette__view-button is-active" data-view="list">
            <svg viewBox="0 0 24 24">
              <path fill="currentColor" d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/>
            </svg>
            <span>List</span>
          </button>
          <button class="command-palette__view-button" data-view="grid">
            <svg viewBox="0 0 24 24">
              <path fill="currentColor" d="M3 3h8v8H3V3zm0 10h8v8H3v-8zM13 3h8v8h-8V3zm0 10h8v8h-8v-8z"/>
            </svg>
            <span>Grid</span>
          </button>
        </div>
      </div>
      <div class="command-palette__content"></div>
      <div class="command-palette__footer">
        <div class="command-palette__shortcuts">
          <span>${shortcutText} Open</span>
          <span>↑↓ Navigate</span>
          <span>↵ Select</span>
          <span>esc Close</span>
          <span>tab Switch View</span>
        </div>
      </div>
    `;

    document.body.appendChild(this.overlay);
    document.body.appendChild(this.palette);

    this.searchInput = this.palette.querySelector('.command-palette__search');
    this.content = this.palette.querySelector('.command-palette__content');
    this.viewButtons = this.palette.querySelectorAll('[data-view]');
  }

  bindEvents() {
    this.searchInput.addEventListener('input', () => {
      this.filterComponents();
      this.renderComponents();
    });

    this.viewButtons.forEach(button => {
      button.addEventListener('click', () => {
        this.switchView(button.dataset.view);
      });
    });

    document.addEventListener('keydown', (e) => {
      if (!this.isOpen) return;

      switch(e.key) {
        case 'Escape':
          e.preventDefault();
          this.close();
          break;

        case 'ArrowDown':
          e.preventDefault();
          this.selectedIndex = Math.min(
            this.selectedIndex + 1,
            this.filteredComponents.length - 1
          );
          this.updateSelection();
          break;

        case 'ArrowUp':
          e.preventDefault();
          this.selectedIndex = Math.max(this.selectedIndex - 1, 0);
          this.updateSelection();
          break;

        case 'Enter':
          e.preventDefault();
          this.selectComponent(this.filteredComponents[this.selectedIndex]);
          break;

        case 'Tab':
          e.preventDefault();
          this.switchView(this.viewMode === 'list' ? 'grid' : 'list');
          break;
      }
    });

    this.overlay.addEventListener('click', () => this.close());
  }

  open() {
    this.isOpen = true;
    this.components = extractComponents();
    this.filteredComponents = [...this.components];
    this.selectedIndex = 0;
    
    this.overlay.style.display = 'block';
    this.palette.style.display = 'block';
    
    requestAnimationFrame(() => {
      this.overlay.classList.add('is-active');
      this.palette.classList.add('is-active');
    });
    
    this.searchInput.value = '';
    this.searchInput.focus();
    
    this.renderComponents();
  }

  close() {
    if (!this.isOpen) return;
    
    this.isOpen = false;
    this.overlay.classList.remove('is-active');
    this.palette.classList.remove('is-active');
    
    const onTransitionEnd = () => {
      if (!this.isOpen) {
        this.overlay.style.display = 'none';
        this.palette.style.display = 'none';
      }
      this.overlay.removeEventListener('transitionend', onTransitionEnd);
    };
    
    this.overlay.addEventListener('transitionend', onTransitionEnd);
  }

  switchView(mode) {
    this.viewMode = mode;
    this.viewButtons.forEach(b => {
      b.classList.toggle('is-active', b.dataset.view === mode);
    });
    this.renderComponents();
  }

  filterComponents() {
    const query = this.searchInput.value.toLowerCase();
    this.filteredComponents = this.components.filter(component =>
      component.label.toLowerCase().includes(query)
    );
    this.selectedIndex = 0;
  }

  renderComponents() {
    if (this.filteredComponents.length === 0) {
      this.renderEmptyState();
      return;
    }

    if (this.viewMode === 'grid') {
      this.renderGridView();
    } else {
      this.renderListView();
    }
    this.updateSelection();
  }

  renderEmptyState() {
    const searchTerm = this.searchInput.value;
    const message = searchTerm 
      ? `No components found matching "${searchTerm}"`
      : 'No components available';

    this.content.innerHTML = `
      <div class="command-palette__empty">
        <div class="command-palette__empty-icon">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M16 16s-1.5-2-4-2-4 2-4 2"/>
            <line x1="9" y1="9" x2="9.01" y2="9"/>
            <line x1="15" y1="9" x2="15.01" y2="9"/>
          </svg>
        </div>
        <p class="command-palette__empty-text">${message}</p>
        ${searchTerm ? `
          <button class="command-palette__empty-button" onclick="this.closest('.command-palette').querySelector('.command-palette__search').value = ''; this.closest('.command-palette').querySelector('.command-palette__search').focus();">
            Clear search
          </button>
        ` : ''}
      </div>
    `;
  }

  renderListView() {
    this.content.innerHTML = `
      <div class="command-palette__list">
        ${this.filteredComponents.map((component, index) => `
          <div class="command-palette__item" data-index="${index}" data-layout="${component.layout}">
            <div class="command-palette__item-content">
              <div class="command-palette__item-title">${component.label}</div>
              ${component.description ? `
                <div class="command-palette__item-description">${component.description}</div>
              ` : ''}
            </div>
          </div>
        `).join('')}
      </div>
    `;

    this.content.querySelectorAll('.command-palette__item').forEach(item => {
      item.addEventListener('mouseenter', () => {
        this.selectedIndex = parseInt(item.dataset.index);
        this.updateSelection();
      });

      item.addEventListener('click', () => {
        const layout = item.dataset.layout;
        if (window.handoff?.addLayout) {
          window.handoff.addLayout(layout);
          this.close();
        }
      });
    });
  }

  renderGridView() {
    this.content.innerHTML = `
      <div class="command-palette__grid">
        ${this.filteredComponents.map((component, index) => `
          <div class="command-palette__grid-item" data-index="${index}" data-layout="${component.layout}">
            <div class="command-palette__grid-item-content">
              <div class="command-palette__grid-icon">
                ${component.icon || component.label[0]}
              </div>
              <div class="command-palette__grid-title">${component.label}</div>
              ${component.description ? `
                <div class="command-palette__grid-description">${component.description}</div>
              ` : ''}
            </div>
          </div>
        `).join('')}
      </div>
    `;

    this.content.querySelectorAll('.command-palette__grid-item').forEach(item => {
      item.addEventListener('mouseenter', () => {
        this.selectedIndex = parseInt(item.dataset.index);
        this.updateSelection();
      });

      item.addEventListener('click', () => {
        const layout = item.dataset.layout;
        if (window.handoff?.addLayout) {
          window.handoff.addLayout(layout);
          this.close();
        }
      });
    });
  }

  updateSelection() {
    const items = this.content.querySelectorAll(
      this.viewMode === 'grid' 
        ? '.command-palette__grid-item' 
        : '.command-palette__item'
    );
    
    items.forEach(item => item.classList.remove('is-selected'));
    items[this.selectedIndex]?.classList.add('is-selected');
    items[this.selectedIndex]?.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
  }

  selectComponent(component) {
    if (!component) return;
    
    if (window.handoff?.addLayout) {
      window.handoff.addLayout(component.layout);
      this.close();
    }
  }
}
