<template>
    <div class="uk-form uk-form-horizontal">
        <h1>{{ 'SEO Settings' | trans }}</h1>
        <div>
            <h2 class="uk-margin-top">{{ 'Site Structure' | trans }}</h2>
            <div>
                <h3 class="uk-margin-top">{{ 'Meta Description' | trans }}</h3>
                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Add Meta Description' | trans }}</label>
                    <div class="uk-form-controls uk-form-controls-text">
                        <input type="checkbox" v-model="package.config.site_structure.meta.description.enabled">
                    </div>
                </div>
                <div class="uk-form-row" v-if="package.config.site_structure.meta.description.enabled">
                    <label class="uk-form-label">{{ 'Use Open Graph Description' | trans }}</label>
                    <div class="uk-form-controls uk-form-controls-text">
                        <input type="checkbox" v-model="package.config.site_structure.meta.description.use_og">
                    </div>
                </div>
                <h3 class="uk-margin-top">{{ 'Title' | trans }}</h3>
                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Overwrite Title' | trans }}</label>
                    <div class="uk-form-controls uk-form-controls-text">
                        <input type="checkbox" v-model="package.config.site_structure.title.enabled">
                    </div>
                </div>
                <div class="uk-margin-top" v-if="package.config.site_structure.title.enabled">
                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Use Sitename' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <input type="checkbox" v-model="package.config.site_structure.title.use_sitename">
                        </div>
                    </div>
                    <div class="uk-form-row" v-if="package.config.site_structure.title.use_sitename">
                        <label for="form-site-structure-title-sitename-ordering"
                               class="uk-form-label">{{ 'Ordering' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <input id="form-site-structure-title-sitename-ordering" type="number"
                                       class="uk-form-width-large"
                                       v-model="package.config.site_structure.title.sitename_ordering"
                                       min="1" number>
                            </p>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Use Path' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <input type="checkbox" v-model="package.config.site_structure.title.use_path">
                        </div>
                    </div>
                    <div class="uk-form-row" v-if="package.config.site_structure.title.use_path">
                        <label for="form-site-structure-title-path-ordering"
                               class="uk-form-label">{{ 'Ordering' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <input id="form-site-structure-title-path-ordering" type="number"
                                       class="uk-form-width-large"
                                       v-model="package.config.site_structure.title.path_ordering"
                                       min="1" number>
                            </p>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Use Pagename' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <input type="checkbox" v-model="package.config.site_structure.title.use_pagename">
                        </div>
                    </div>
                    <div class="uk-form-row" v-if="package.config.site_structure.title.use_pagename">
                        <label for="form-site-structure-title-pagename-ordering"
                               class="uk-form-label">{{ 'Ordering' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <input id="form-site-structure-title-pagename-ordering" type="number"
                                       class="uk-form-width-large"
                                       v-model="package.config.site_structure.title.pagename_ordering"
                                       min="1" number>
                            </p>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Use Open Graph Title' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <input type="checkbox" v-model="package.config.site_structure.title.use_og">
                        </div>
                    </div>
                    <div class="uk-form-row" v-if="package.config.site_structure.title.use_og">
                        <label for="form-site-structure-title-og-ordering"
                               class="uk-form-label">{{ 'Ordering' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <input id="form-site-structure-title-og-ordering" type="number"
                                       class="uk-form-width-large"
                                       v-model="package.config.site_structure.title.og_ordering"
                                       min="1" number>
                            </p>
                        </div>
                    </div>
                    <div class="uk-form-row" v-if="package.config.site_structure.title.use_path">
                        <label for="form-site-structure-title-path-ordering"
                               class="uk-form-label">{{ 'Start Level' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <p class="uk-form-controls-condensed">
                                <input id="form-site-structure-title-path-level" type="number"
                                       class="uk-form-width-large"
                                       v-model="package.config.site_structure.title.path_level"
                                       min="0" number>
                            </p>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label for="form-title-separator" class="uk-form-label">{{ 'Separator' | trans }}</label>
                        <div class="uk-form-controls">
                            <input id="form-title-separator" class="uk-form-width-medium" type="text" v-model="package.config.site_structure.title.separator">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-form-row uk-margin-top">
            <div class="uk-form-controls">
                <button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>
             </div>
        </div>
    </div>
</template>
<script>

module.exports = {

	settings: true,

	props: ['package'],

	methods: {
		save: function save() {
			this.$http.post ('admin/system/settings/config', {
				name: 'spqr/seo',
				config: this.package.config
			}).then (function () {
				this.$notify ('Settings saved.', '');
			}).catch (function (response) {
				this.$notify (response.message, 'danger');
			}).finally (function () {
				this.$parent.close ();
			});
		}
	}
};

window.Extensions.components['seo-settings'] = module.exports;
</script>