<template>
    <div>
        <dropzone
                id="myVueDropzone"
                url="/admin/browser/file"
                ref="uploaderDropzone"
                :headers="headers"
                :useFontAwesome="true"
                v-on:vdropzone-success="showSuccess"
                v-on:vdropzone-error="showError"
                v-on:vdropzone-sending="uploadFile"
                v-bind:preview-template="template">
        </dropzone>
    </div>
</template>

<script>
    import Dropzone from 'vue2-dropzone'

    export default {
        mounted() {

        },
        computed: {
            headers: function () {
                return {'X-CSRF-TOKEN': window.Laravel.csrfToken}
            }
        },
        components: {
            Dropzone
        },
        methods: {
            'uploadFile': function(file, xhr, formData) {
                formData.append('files[]', file);
                formData.append('folder', this.$parent.currentPath);
            },
            'processFile': function (file) {
                this.$emit('change', this.$refs.uploaderDropzone.getAcceptedFiles());
            },
            'showSuccess': function (file, response) {
                this.$parent.mediaManagerNotify(response.success);
                this.$parent.loadFolder(this.$parent.currentPath);
            },
            'showError': function (file, response) {
                let error = (response.error) ? response.error : response.statusText;
                // when uploading we might have some files uploaded and others fail
                if (response.notices) this.$parent.mediaManagerNotify(response.notices);
                this.$parent.mediaManagerNotify(error, 'danger', 5000);
                this.$parent.errors = error;
                this.$parent.loadFolder(this.$parent.currentPath);

            },
            'template': function () {
                return `
                  <div class="dz-preview dz-file-preview">
                      <div class="dz-image" style="width: 200px;height: 200px">
                          <img data-dz-thumbnail /></div>
                      <div class="dz-details">
                        <div class="dz-size"><span data-dz-size></span></div>
                        <div class="dz-filename"><span class="word-wrappable" data-dz-name></span></div>
                      </div>
                      <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                      <div class="dz-success-mark"><i class="fa fa-check"></i></div>
                      <div class="dz-error-mark"><i class="fa fa-close"></i></div>
                  </div>
              `;
            }
        }
    }
</script>

<style lang="scss">
    #myVueDropzone.vue-dropzone {
        font-family: inherit;
        letter-spacing: inherit;
        color: #777;
        transition: background-color .2s linear;
        &:hover {
            background-color: #F6F6F6;
        }
        i {
            color: #CCC;
        }
        .dz-preview {
            .dz-image {
                border-radius: 1;
                &:hover {
                    img {
                        transform: none;
                        -webkit-filter: none;
                    }
                }
            }
            .dz-details {
                bottom: 0;
                top: 0;
                color: white;
                background-color: rgba(33, 150, 243, 0.8);
                transition: opacity .2s linear;
                text-align: left;
                .dz-filename span, .dz-size span {
                    background-color: transparent;
                }
                .dz-filename:not(:hover) span {
                    border: none;
                }
                .dz-filename:hover span {
                    background-color: transparent;
                    border: none;
                }
            }
            .dz-error-message {
                text-overflow: ellipsis !important;
            }
            .dz-progress .dz-upload {
                background: #cccccc;
            }
            .dz-remove {
                position: absolute;
                z-index: 30;
                color: white;
                margin-left: 15px;
                padding: 10px;
                top: inherit;
                bottom: 15px;
                border: 2px white solid;
                text-decoration: none;
                text-transform: uppercase;
                font-size: 0.8rem;
                font-weight: 800;
                letter-spacing: 1.1px;
                opacity: 0;
            }
            &:hover {
                .dz-remove {
                    opacity: 1;
                }
            }
            .dz-success-mark, .dz-error-mark {
                margin-left: auto !important;
                margin-top: auto !important;
                width: 100% !important;
                top: 35% !important;
                left: 0;
                i {
                    font-size: 5rem !important;
                }
            }
            .dz-success-mark i {
                color: green !important;
            }
            .dz-error-mark i {
                color: red !important;
            }
        }
    }
</style>