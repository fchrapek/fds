import PostAjaxLoader from './modules/post-ajax.js';

function domReady(callback) {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', callback);
  } else {
    callback();
  }
}

domReady(() => {  
  new PostAjaxLoader();
});