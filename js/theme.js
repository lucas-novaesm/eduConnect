// Gerenciador de tema
class ThemeManager {
  constructor() {
    this.theme = localStorage.getItem('theme') || 'light';
    this.init();
  }

  init() {
    // Aplicar tema inicial
    this.applyTheme();

    // Adicionar toggle de tema no header
    this.createThemeToggle();

    // Observar preferência do sistema
    this.watchSystemPreference();
  }

  createThemeToggle() {
    const nav = document.querySelector('.nav-user');
    if (!nav) return;

    const toggle = document.createElement('button');
    toggle.className = 'theme-toggle';
    toggle.setAttribute('aria-label', 'Alternar tema');
    toggle.innerHTML = `
      <i class="fas fa-sun light-icon"></i>
      <i class="fas fa-moon dark-icon"></i>
    `;

    toggle.addEventListener('click', () => this.toggleTheme());
    nav.insertBefore(toggle, nav.firstChild);

    // Adicionar estilos
    const style = document.createElement('style');
    style.textContent = `
      .theme-toggle {
        background: transparent;
        border: none;
        color: var(--text-color);
        padding: 0.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--border-radius-full);
        transition: all var(--transition-fast);
      }

      .theme-toggle:hover {
        background: rgba(0, 0, 0, 0.1);
      }

      [data-theme="dark"] .theme-toggle:hover {
        background: rgba(255, 255, 255, 0.1);
      }

      .theme-toggle .light-icon,
      .theme-toggle .dark-icon {
        font-size: 1.25rem;
      }

      [data-theme="light"] .dark-icon,
      [data-theme="dark"] .light-icon {
        display: none;
      }
    `;
    document.head.appendChild(style);
  }

  applyTheme(theme = this.theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    this.theme = theme;
  }

  toggleTheme() {
    const newTheme = this.theme === 'light' ? 'dark' : 'light';
    this.applyTheme(newTheme);
  }

  watchSystemPreference() {
    // Observar mudanças na preferência do sistema
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    
    const handleChange = (e) => {
      if (!localStorage.getItem('theme')) {
        this.applyTheme(e.matches ? 'dark' : 'light');
      }
    };

    mediaQuery.addListener(handleChange);
    
    // Verificar preferência inicial
    if (!localStorage.getItem('theme')) {
      handleChange(mediaQuery);
    }
  }
}

// Inicializar gerenciador de tema quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
  new ThemeManager();
});
