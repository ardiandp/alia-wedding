window.seoFields = (config) => ({
    metaTitle: config.metaTitle ?? '',
    metaDescription: config.metaDescription ?? '',
    previewTitle: '',
    previewDescription: '',
    previewUrl: config.previewUrl ?? '',
    titleLimit: config.titleLimit ?? 60,
    descriptionLimit: config.descriptionLimit ?? 160,
    defaultTitle: config.defaultTitle ?? '',
    defaultDescription: config.defaultDescription ?? '',

    init() {
        this.syncPreview();
    },

    watch: {
        metaTitle() {
            this.syncPreview();
        },

        metaDescription() {
            this.syncPreview();
        },
    },

    lengthOf(field) {
        return (field === 'title' ? this.metaTitle : this.metaDescription).length;
    },

    limitOf(field) {
        return field === 'title' ? this.titleLimit : this.descriptionLimit;
    },

    counter(field) {
        const length = this.lengthOf(field);
        const limit = this.limitOf(field);

        if (length === 0) {
            return 'Opsional';
        }

        if (length > limit) {
            return length + ' / ' + limit + ' - terlalu panjang';
        }

        if (length > limit - 15) {
            return length + ' / ' + limit + ' - mendekati batas';
        }

        return length + ' / ' + limit;
    },

    counterClass(field) {
        const length = this.lengthOf(field);
        const limit = this.limitOf(field);

        if (length === 0) {
            return 'text-gray-400 dark:text-gray-500';
        }

        if (length > limit) {
            return 'font-medium text-red-600 dark:text-red-400';
        }

        if (length > limit - 15) {
            return 'font-medium text-yellow-600 dark:text-yellow-400';
        }

        return 'font-medium text-green-600 dark:text-green-400';
    },

    syncPreview() {
        this.previewTitle = this.metaTitle.trim() || this.defaultTitle;
        this.previewDescription =
            this.metaDescription.trim() || this.defaultDescription;
    },
});