const CONFIG = {
    CONTAINER_ID: 'latest-posts',
    REST_ENDPOINT: '/wp-json/twentytwentyfive-child/v1/ajax/load-posts',
    POST_TYPE: 'library',
    PER_PAGE: '20',
    TAXONOMY: 'book-genre',
    MESSAGES: {
        LOADING: 'Loading latest books...',
        ERROR: 'Failed to load books.',
        NO_POSTS: 'No other books found.',
        SECTION_TITLE: 'Latest Books'
    }
};

class PostAjaxLoader {
    constructor() {
        this.init();
    }

    init() {
        if (typeof ajaxData === 'undefined') {
            return;
        }

        this.loadLatestPosts();
    }

    async loadLatestPosts() {
        const container = document.getElementById(CONFIG.CONTAINER_ID);
        if (!container) {
            return;
        }

        container.innerHTML = `<div class="loading">${CONFIG.MESSAGES.LOADING}</div>`;

        try {
            const restUrl = `${window.location.origin}${CONFIG.REST_ENDPOINT}`;
            
            const formData = new FormData();
            formData.append('post_type', CONFIG.POST_TYPE);
            formData.append('exclude_id', ajaxData.current_post_id);
            formData.append('per_page', CONFIG.PER_PAGE);
            formData.append('taxonomy', CONFIG.TAXONOMY);

            const response = await fetch(restUrl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                this.renderPosts(data, container);
            } else {
                container.innerHTML = `<div class="error">${CONFIG.MESSAGES.ERROR}</div>`;
            }
        } catch (error) {
            console.error('REST API Error:', error);
            container.innerHTML = `<div class="error">${CONFIG.MESSAGES.ERROR}</div>`;
        }
    }

    renderPosts(posts, container) {
        if (!posts || posts.length === 0) {
            container.innerHTML = `<div class="no-posts">${CONFIG.MESSAGES.NO_POSTS}</div>`;
            return;
        }

        // most likely in real life scenario we would load a component here
        const postsHtml = posts.map(post => `
            <div class="post-item">
                <h3><a href="${post.permalink}">${post.title}</a></h3>
                <div class="post-meta">
                    <span class="post-date">${post.date}</span>
                    ${post.terms && post.terms.length > 0 ? 
                        `<span class="post-terms">
                            Genre: ${post.terms.map(term => 
                                `<a href="${term.link}">${term.name}</a>`
                            ).join(', ')}
                        </span>` : ''
                    }
                </div>
                <div class="post-excerpt">${post.excerpt}</div>
            </div>
        `).join('');

        container.innerHTML = `
            <h2>${CONFIG.MESSAGES.SECTION_TITLE}</h2>
            <div class="posts-grid">
                ${postsHtml}
            </div>
        `;
    }
}

export default PostAjaxLoader;
