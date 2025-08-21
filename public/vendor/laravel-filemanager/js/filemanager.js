/**
 * Open file manager and return selected files.
 * Promise is never resolved if window is closed.
 *
 * @returns Promise<array> Array of selected files with properties:
 *      icon        string
 *      is_file     bool
 *      is_image    bool
 *      name        string
 *      thumb_url   string|null
 *      time        int
 *      url         string
 */

function filemanager(elements, options = {}) {
    const type = options.type || 'file';
    const prefix = options.prefix || '/filemanager';

    const nodes = typeof elements === 'string'
        ? document.querySelectorAll(elements)
        : (elements instanceof NodeList ? elements
            : Array.isArray(elements) ? elements
                : [elements]);

    nodes.forEach(node => {
        node.addEventListener('click', (e) => {
            e.preventDefault();

            const { input: inputId, preview: previewId, path = '' } = e.currentTarget.dataset || {};
            if (inputId)  localStorage.setItem('target_input', inputId);
            if (previewId) localStorage.setItem('target_preview', previewId);

            const url = `${prefix}?type=${encodeURIComponent(type)}${path ? `&working_dir=${encodeURIComponent(path)}` : ''}`;


            window.filemanager(url).then((urlOrItems) => {
                let chosenUrl = urlOrItems;
                let chosenPath = null;

                if (Array.isArray(urlOrItems)) {
                    const item = urlOrItems[0] || {};
                    chosenUrl = item.url;
                    chosenPath = item.name || item.path || item.url;
                }

                const targetInputId = localStorage.getItem('target_input');
                const targetPreviewId = localStorage.getItem('target_preview');

                if (targetInputId) {
                    const inputEl = document.getElementById(targetInputId);
                    if (inputEl) {
                        let relativeUrl = chosenUrl.replace(/^https?:\/\/[^/]+/, '');
                        inputEl.value = relativeUrl || '';
                        inputEl.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }

                if (targetPreviewId) {
                    const previewEl = document.getElementById(targetPreviewId);
                    if (previewEl) {
                        if ('src' in previewEl) {
                            previewEl.src = chosenUrl;
                        } else {
                            previewEl.style.backgroundImage = `url("${chosenUrl}")`;
                        }
                        previewEl.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            });
        }, { passive: false });
    });
}
filemanager('.lfm', { type: 'image', prefix: '/filemanager' });
