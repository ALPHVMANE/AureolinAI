document.addEventListener("DOMContentLoaded", function() {
    const setBodyBackground = () => {
      const location = window.location.pathname;
  
      switch (location) {
        case '/home':
          document.body.style.backgroundColor = 'lightblue';
          break;
        case '/login':
          document.body.style.backgroundImage = `url(${AuthBg})`;
          document.body.style.backgroundSize = 'cover';
          document.body.style.backgroundPosition = 'center';
          break;
        case '/signup':
          document.body.style.backgroundImage = `url(${AuthBg})`;
          document.body.style.backgroundSize = 'cover';
          document.body.style.backgroundPosition = 'center';
          break;
        default:
          document.body.style.backgroundColor = 'white';
      }
    };
  
    setBodyBackground();
  
    // reset bg when in new page
    window.addEventListener('popstate', () => {
      document.body.style.backgroundColor = '';
      document.body.style.backgroundImage = '';
    });
  });