document.addEventListener('DOMContentLoaded', () => {
  const html = document.documentElement;
  const toggle = document.getElementById('themeToggle');
  const dot = document.getElementById('themeDot');

  if (!toggle || !dot) return;

  if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    html.classList.add('dark');
    dot.classList.add('translate-x-7');
  }

  toggle.addEventListener('click', () => {
    const isDark = html.classList.toggle('dark');
    localStorage.theme = isDark ? 'dark' : 'light';
    dot.classList.toggle('translate-x-7', isDark);
  });
});