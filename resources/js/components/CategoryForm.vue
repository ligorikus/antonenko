<template>
    <div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Название категории</label>
                <input type="text" v-model="name" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Параметры</label>
                <div class="row form-group" v-for="(option, key) in options">
                    <div class="col-md-5">
                        <input type="text" v-model="options[key].title" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <select v-model="options[key].type" class="form-control">
                            <option value="string">Строка</option>
                            <option value="numeric">Число</option>
                            <option value="boolean">Переключатель</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:;" @click="deleteOption(key)">Удалить</a>
                    </div>
                </div>
                <div class="row">
                    <a href="javascript:;" @click="addOption">Добавить параметр</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-primary" @click="send" :disabled="!isValid">
                    <span v-if="is_new">Создать</span><span v-else>Изменить</span> категорию
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CategoryForm",
        props: {
            category: Object
        },
        data: function () {
            return {
                id: 0,
                name: '',
                options: [],
                is_new: true
            }
        },
        methods: {
            addOption: function () {
                this.options.push({
                    title: '',
                    type: 'numeric'
                })
            },
            deleteOption: function (key) {
                this.options.splice(key, 1);
            },
            send: function (config) {
                if (this.is_new) {
                    this.$http
                        .post(this.sendRoute, {
                            name: this.name,
                            options: this.options
                        })
                        .then((response) => {
                            document.location.href = '/categories';
                        });
                } else {
                    this.$http
                        .put(this.sendRoute, {
                            name: this.name,
                            options: this.options
                        })
                        .then((response) => {
                            document.location.href = '/categories';
                        });
                }

            }
        },
        created() {
            if (this.category) {
                this.is_new = false;
                this.name = this.category.name;
                this.options = this.category.options;
            }
        },
        computed: {
            isValid: function () {
                return this.name.length
                    && this.options.length
                    && !this.options.filter((item) => !item.title.length).length;
            },
            sendRoute: function () {
                return this.is_new ? '/categories' : '/categories/'+this.category.id;
            },
        }
    }
</script>

<style scoped>

</style>
