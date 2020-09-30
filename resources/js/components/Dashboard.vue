<template>
    <div>
        <div class="col-md-3">
            <div class="col-md-12 search">
                <input v-model="name" type="text" class="search__input" @keydown.enter="reloadProducts" placeholder="Введите название товара">
            </div>
            <div class="col-md-12">
                <select v-model="selected_category" class="form-control" @change="selectCategory">
                    <option value="noselect" selected="selected">Выбрать категорию</option>
                    <option :value="category" v-for="category in categories">{{category.name}}</option>
                </select>
            </div>
            <div class="col-md-12">
                <div style="margin-left: 10px" class="row form-group" v-if="option.type !== 'string' && option.type !== 'boolean'" v-for="option in selected_category.options">
                    <div class="col-form-label">{{option.title}}</div>
                    <span v-if="option.type === 'numeric'">
                        <input v-model.number="options[option.id][0]" type="text" class="col-md-4">-
                        <input v-model.number="options[option.id][1]" type="text" class="col-md-4">
                    </span>
                    <!--<input v-model="options[option.id]" v-if="option.type === 'boolean'" type="checkbox" class="form-control col-md-1">-->
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary" @click="reloadProducts">Поиск</button>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <a target="_blank" href="https://www.omgtu.ru/general_information/faculties/faculty_of_information_technology_and_computer_systems/department_of_automated_systems_of_information_processing_and_management">
                    <img class="col-md-6" src="https://omgtu.ru/general_information/files/logo%20OmGTU%20wb%20gor.png" alt="Кафедра АСОИУ">
                </a>
            </div>
            <div class="row">
                <div class="col-md-6 py-3" v-for="product in products">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                {{product.name}}
                                <span class="float-right">{{product.category_name}}</span>
                            </div>
                            <div class="card-text">
                                <img class="card-img" :src="product.image" alt="" v-if="product.image">
                            </div>
                            <a class="btn btn-primary" :href="'/products/'+product.id+'/show'">Посмотреть</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        props: {
            categories: Array
        },
        data: function () {
            return {
                name: '',
                options: {},
                selected_category: 'noselect',
                products: [],
                page: 1
            }
        },
        methods: {
            selectCategory: function () {
                var self = this;
                if (this.selected_category === 'noselect') {
                    this.options = {};
                    return false;
                }
                this.selected_category.options.map((item) => {
                    if (item.type === 'numeric') {
                        self.$set(self.options, item.id, [0, 0]);
                    } else if (item.type === 'boolean') {
                        self.$set(self.options, item.id, false);
                    }
                });
            },
            reloadProducts: function  () {
                this.page = 1;
                this.products = [];
                this.getProducts();
            },
            getProducts: function () {
                if (this.in_process) {
                    return;
                }
                this.in_process = true;
                var self = this;
                this.$http.get(this.makeURL())
                    .then(response => {
                        response.data.data.forEach(item => self.products.push(item));
                        this.page++;
                        this.in_process = false;
                    });
            },
            makeURL: function () {
                var self = this;
                var url = '/ajax/products?page='+this.page+'&';
                if (this.name.length) {
                    url += 'filter[name]='+this.name+'&';
                }
                if (this.selected_category !== 'noselect') {
                    url += 'filter[category_id]='+this.selected_category.id+'&';
                }
                Object.keys(this.options).forEach((key) => {
                    if (Array.isArray(self.options[key])) {
                        url += 'filter[options]['+key+'][0]='+self.options[key][0]+'&filter[options]['+key+'][1]='+self.options[key][1]+'&'
                    } else {
                        url += 'filter[options]['+key+']='+self.options[key]+'&';
                    }
                });

                return url.slice(0, -1);
            },
            scroll () {
                window.onscroll = () => {
                    let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;

                    if (bottomOfWindow) {
                        this.getProducts();
                    }
                };
            },
        },
        mounted() {
            this.reloadProducts();
            this.scroll();
        }
    }
</script>

<style scoped lang="scss">
    .search {
        &__input {
            border: 0;
            font-size: 16px;
            width: 100%;
        }
        line-height: 32px;
        margin-bottom: 10px;
    }
</style>
