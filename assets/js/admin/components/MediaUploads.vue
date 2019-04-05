<style lang="scss">
    .drop {
        width: 100%;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed darken(#eee, 23%);
        border-radius: 5px;
        background: #eee;

        input {
            display: none;
        }
    }

    .media-list {
        display: flex;
        flex-wrap: wrap;
        margin-left: -5px;
        margin-right: -5px;

        .media-preview {
            position: relative;
            display: flex;
            height: 160px;
            border: 1px solid #eee;
            padding: 5px;
            margin: 5px;
            max-width: 100%;
            overflow-x: scroll;

            img {
                width: auto;
                height: 100%;
                margin: auto;
            }

            video {
                width: auto;
                height: 100%;
            }

            .actions {
                position: absolute;
                top: 10px;
                right: 10px;
                opacity: 0;
                transition: 1s all ease;

                button {
                    background: rgba(#000, .5);

                    i {
                        color: #fff;
                    }
                }
            }

            &:hover {
                .actions {
                    opacity: 1;
                }
            }
        }
    }
</style>

<template>
    <div id="media-uploads">
        <form @submit.prevent>
            <label class="drop">
                <input type="file"
                       ref="filesInput"
                       @change="storeMedia"
                       multiple
                >
                <span v-text="input_label"></span>
            </label>
        </form>

        <div class="media-list">
            <div class="media-preview" v-for="media in uploads">
                <video v-if="media.mime_type === 'video/mp4'" :src="media.url" autoplay loop></video>
                <img v-else :src="media.url" :alt="media.name">

                <div class="actions">
                    <button class="btn btn-link" @click="editMedia(media)">
                        <i class="fas fa-pencil-alt"></i>
                    </button>

                    <button class="btn btn-link" @click="deleteMedia(media)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit-media" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Media</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form @submit.prevent="updateMedia(modal_media)">
                            <div class="form-group">
                                <label for="name">Filename</label>
                                <input type="text"
                                       class="form-control"
                                       id="name"
                                       v-model="modal_media.name"
                                >
                            </div>

                            <div class="form-group">
                                <label for="collection_name">Media Collection</label>
                                <select class="form-control text-capitalize"
                                        id="collection_name"
                                        v-model="modal_media.collection_name"
                                >
                                    <option v-for="collection in collections"
                                            :value="collection"
                                            v-text="collection"
                                    ></option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button"
                                ref="updateButton"
                                class="btn btn-success"
                                @click="updateMedia(modal_media)"
                        >
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import api from './../requests';

    let MediaUploads = {
        name: 'media-uploads',
        props: [
            'create_url',
            'update_url',
            'delete_url',
            'mediable_type',
            'mediable_id',
            'media',
            'media_collections',
        ],

        data: function () {
            return {
                files: [],
                input_label: 'Click here to upload files.',
                uploads: this.$props.media !== undefined ? this.$props.media : [],
                collections: this.$props.media_collections !== undefined
                    ? this.$props.media_collections
                    : ['default', 'image', 'images', 'videos'],
                url: {
                    create: this.$props.create_url !== undefined ? this.$props.create_url : '/admin/media',
                    update: this.$props.update_url !== undefined ? this.$props.update_url : '/admin/media',
                    delete: this.$props.delete_url !== undefined ? this.$props.delete_url : '/admin/media',
                },
                modal_media: {},
                temporary_id: null,
            }
        },

        mounted: function () {
            this.$nextTick(function () {
                // check for temporary model previously created
                this.temporary_id = window.localStorage.getItem('temporary_media_id');

                if (this.temporary_id) {
                    this.setHiddenInput();

                    this.getTemporaryMedia()
                }
            });
        },

        methods: {
            async getTemporaryMedia() {
                if (!this.$props.mediable_id) {
                    await api.axios.get(`/admin/media/temporary/${this.temporary_id}`)
                        .then(response => this.uploads = response.data)
                        .catch(errors => {
                            window.localStorage.removeItem('temporary_media_id');

                            this.temporary_id = null;

                            console.log("Couldn't fetch the temporary media.", errors.response)
                        });
                }
            },

            async storeMedia() {
                this.files = Array.from(this.$refs.filesInput.files);

                // disable the input
                this.$refs.filesInput.disabled = true;
                this.input_label = 'Working, please wait!';

                if (!this.$props.mediable_id && !this.temporary_id) {
                    // get one temporary model
                    await api.axios.post('/admin/media/temporary')
                        .then(response => {
                            this.temporary_id = response.data.id;
                            this.setHiddenInput();
                            window.localStorage.setItem('temporary_media_id', this.temporary_id);
                        })
                        .catch(errors => console.log(errors.response, 'Failed to create temporary model'));
                }

                // store the files synchronously
                for (let file of this.files) {
                    let formData = new FormData();

                    formData.append('file', file);
                    formData.append('mediable_type', this.mediableType);
                    formData.append('mediable_id', this.mediableId);

                    await axios.post(this.url.create, formData)
                        .then(response => {
                            this.uploads.push(response.data.media);
                            this.$parent.notify(`Successfully uploaded ${file.name}`, 'success');
                        })
                        .catch(errors => this.handleFailure(errors, file, 'Failed to upload'));
                }

                // enable the input
                this.$refs.filesInput.disabled = false;
                this.input_label = 'Click here to upload files.';

                this.files = [];
            },

            editMedia(media) {
                this.modal_media = JSON.parse(JSON.stringify(media));
                $('#edit-media').modal('show');
            },

            updateMedia(media) {
                this.toggleUpdateButton(false);

                api.axios.patch(this.url.update + '/' + media.id, media)
                    .then(response => {
                        let original = this.uploads.find(m => m.id === media.id);

                        original.name = media.name;
                        original.collection_name = media.collection_name;

                        this.toggleUpdateButton(true);

                        this.$parent.notify(`Successfully updated ${media.name}`, 'success');

                        $('#edit-media').modal('hide');
                    })
                    .catch(errors => {
                        this.handleFailure(errors, media, 'Failed to update');
                        this.toggleUpdateButton(true);
                    })
            },

            deleteMedia(media) {
                api.axios.delete(this.url.delete + '/' + media.id)
                    .then(response => {
                        this.uploads.splice(this.uploads.indexOf(media), 1);
                        this.$parent.notify(`Successfully delete ${media.name}`, 'success');
                    })
                    .catch(errors => this.handleFailure(errors, media, 'Failed to delete'))
            },

            handleFailure(errors, media, message) {
                this.$parent.notify(`${errors.response.data.message} ${media.name}`, 'error', 10000);
                this.$parent.notify(`${message} ${media.name}`, 'error', 10000);
                console.log(errors, errors.response, media);
            },

            toggleUpdateButton(state) {
                let button = this.$refs.updateButton;

                if (state) {
                    button.disabled = false;
                    button.textContent = 'Save changes';
                } else {
                    button.disabled = true;
                    button.textContent = 'Working, please wait!';
                }
            },

            setHiddenInput() {
                let input = document.createElement('input');
                input.name = 'temporary_id';
                input.type = 'hidden';
                input.value = this.temporary_id;
                document.querySelector('main form').appendChild(input);
            }
        },

        computed: {
            mediableType() {
                if (this.$props.mediable_type) {
                    return this.$props.mediable_type;
                }

                return 'Oxygencms\\Core\\Models\\Temporary'
            },

            mediableId() {
                if (this.$props.mediable_id) {
                    return this.$props.mediable_id;
                }

                return this.temporary_id;
            },
        }
    };

    export default MediaUploads;
</script>
