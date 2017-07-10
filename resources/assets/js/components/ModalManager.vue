<template>
    <div class="media-wrapper">
        <media-modalx v-if="showMediaManager" @close="showMediaManager = false">
            <media-managerx
                :is-modal="true"
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
                showMediaManager: false
            }
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
        max-height: 500px;
    }
</style>