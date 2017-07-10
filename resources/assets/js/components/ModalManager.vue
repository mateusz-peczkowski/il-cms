<template>
    <div class="media-wrapper">
        <media-modalx v-if="showMediaManager" @close="showMediaManager = false">
            <media-managerx
                :is-modal="true"
                selected-event-name="media"
                @close="showMediaManager = false"
            >
            </media-managerx>
        </media-modalx>
    </div>
</template>

<script>
    import MediaModal from '../../talvbansal/media-manager/js/components/MediaModal.vue'
    import MediaManager from '../../talvbansal/media-manager/js/components/MediaManager.vue'

    export default {
        data: function () {
            return {
                showMediaManager: false,
                selectedMedia: null
            }
        },
        mounted () {
            window.eventHub.$on('media-manager-selected-media', function (file) {
                this.selectedMedia = file.webPath;

                // Hide the Media Manager...
                this.showMediaManager = false;
            }.bind(this))
        },
        components: {
            'media-modalx': MediaModal,
            'media-managerx': MediaManager
        },
        computed: {
            headers: function () {
                return {'X-CSRF-TOKEN': window.Laravel.csrfToken}
            }
        }
    }
</script>

<style lang="scss">
    .media-wrapper {
        overflow: auto;
    }
</style>