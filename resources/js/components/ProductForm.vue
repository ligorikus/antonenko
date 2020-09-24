<template>
    <div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Название продукта</label>
                <input type="text" v-model="name" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Параметры</label>

            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-primary" @click="send" :disabled="!isValid">
                    <span v-if="is_new">Создать</span><span v-else>Изменить</span> продукт
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductForm",
        props: {
            product: Object
        },
        data: function () {
            return {
                id: 0,
                name: '',
                is_new: true
            }
        },
        methods: {
            send: function (config) {
                if (this.is_new) {
                    this.$http
                        .post(this.sendRoute, {
                            name: this.name,
                        })
                        .then((response) => {
                            document.location.href = '/products';
                        });
                } else {
                    this.$http
                        .put(this.sendRoute, {
                            name: this.name,
                        })
                        .then((response) => {
                            document.location.href = '/products';
                        });
                }

            }
        },
        created() {
            if (this.product) {
                this.is_new = false;
                this.name = this.product.name;
            }
        },
        computed: {
            isValid: function () {
                return this.name.length;
            },
            sendRoute: function () {
                return this.is_new ? '/categories' : '/categories/'+this.category.id;
            },
        }
    }
</script>

<style scoped>

</style>
