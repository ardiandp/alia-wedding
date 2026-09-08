window.mediaPicker = (opts, fieldName) => ({
    fieldName,
    value: opts.value ?? null,
    preview: opts.preview ?? null,
    uploading: false,
    error: null,
    browserOpen: false,
    browserHtml: '',
    uploadUrl: opts.uploadUrl,
    browserUrl: opts.browserUrl,

    openBrowser() {
        this.browserOpen = true;
        this.error = null;

        if (this.browserHtml) {
            return;
        }

        fetch(this.browserUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then((res) => res.text())
            .then((html) => {
                this.browserHtml = html;
            })
            .catch(() => {
                this.error = 'Gagal memuat media library.';
            });
    },

    pick(path, url) {
        this.value = path;
        this.preview = url;
        this.browserOpen = false;
    },

    async upload(event) {
        const file = event.target.files[0];
        if (!file) {
            return;
        }

        this.uploading = true;
        this.error = null;

        const formData = new FormData();
        formData.append('file', file);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        try {
            const response = await fetch(this.uploadUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            const data = await response.json();

            if (data.ok) {
                this.value = data.path;
                this.preview = data.url;
            } else {
                this.error = data?.errors?.file?.[0] ?? 'Upload gagal.';
            }
        } catch (error) {
            this.error = 'Upload gagal.';
        } finally {
            this.uploading = false;
            event.target.value = '';
        }
    },

    clearValue() {
        this.value = null;
        this.preview = null;
    },
});

window.mediaUploader = (opts) => ({
    uploading: false,
    error: null,
    uploadUrl: opts.uploadUrl,

    async upload(event) {
        const file = event.target.files[0];
        if (!file) {
            return;
        }

        this.uploading = true;
        this.error = null;

        const formData = new FormData();
        formData.append('file', file);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        try {
            const response = await fetch(this.uploadUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            const data = await response.json();

            if (data.ok) {
                window.dispatchEvent(new CustomEvent('upload-success'));
            } else {
                this.error = data?.errors?.file?.[0] ?? 'Upload gagal.';
            }
        } catch (error) {
            this.error = 'Upload gagal.';
        } finally {
            this.uploading = false;
            event.target.value = '';
        }
    },
});