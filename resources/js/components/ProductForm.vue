<template>
    <div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Название продукта</label>
                <input type="text" v-model="name" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Описание</label>
                <textarea class="form-control" v-model="description"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <input type="file" @change='upload_image' name="image">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <select v-model="selected_category" class="form-control" @change="selectCategory" :disabled="product">
                    <option
                        :value="category" v-for="category in categories">{{category.name}}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Параметры</h2>
                <div class="row form-group" v-for="(category_option, key) in selected_category.options">
                    <div class="col-md-4 col-form-label">{{category_option.title}}</div>
                    <input type="text" v-model="options[category_option.id]"
                           v-if="category_option.type === 'string'"
                           class="form-control col-md-8">
                    <input type="number" v-model.number="options[category_option.id]"
                           v-if="category_option.type === 'numeric'"
                           class="form-control col-md-8">
                    <input type="checkbox"
                           v-if="category_option.type === 'boolean'"
                           v-model="options[category_option.id]"
                           class="form-control col-md-1">
                </div>
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
            product: Object,
            categories: Array
        },
        data: function () {
            return {
                id: 0,
                name: '',
                description: '',
                is_new: true,
                selected_category: {},
                options: {},
                image: ''
            }
        },
        methods: {
            send: function (config) {
                if (this.is_new) {
                    this.$http
                        .post(this.sendRoute, {
                            name: this.name,
                            description: this.description,
                            image: this.image,
                            category_id: this.selected_category.id,
                            options: this.options
                        })
                        .then((response) => {
                            document.location.href = '/products';
                        });
                } else {
                    this.$http
                        .put(this.sendRoute, {
                            name: this.name,
                            description: this.description,
                            image: this.image,
                            category_id: this.selected_category.id,
                            options: this.options
                        })
                        .then((response) => {
                            document.location.href = '/products';
                        });
                }

            },
            upload_image(e){
                let file = e.target.files[0];
                console.log(e.target.files[0]);

                let data = new FormData();
                data.append('image', file);

                if(file['size'] < 2111775)
                {
                    this.$http.post('img/product', data).then((response) => {
                        this.image = response.data.location;
                    });
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
            },
            selectCategory: function () {
                var self = this;
                this.selected_category.options.map((item) => {
                    if (item.type === 'numeric' || item.type === 'string') {
                        self.$set(self.options, item.id, null);
                    } else if (item.type === 'boolean') {
                        self.$set(self.options, item.id, false);
                    }
                });
            }
        },
        created() {
            if (this.product) {
                this.is_new = false;
                this.name = this.product.name;
                this.description = this.product.description;
                this.selected_category = this.categories.find((item) => item.id === this.product.category_id);
                this.options = this.product.options;
            }
        },
        computed: {
            isValid: function () {
                return this.name.length > 0
                    && this.selected_category !== undefined
                    && !Object.values(this.options).filter((item) => item === null).length;
            },
            sendRoute: function () {
                return this.is_new ? '/products' : '/products/'+this.product.id;
            }
        }
    }
</script>

<style scoped>

</style>
