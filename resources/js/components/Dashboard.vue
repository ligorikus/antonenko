<template>
    <div>
        <div class="col-md-3">
            <div class="col-md-12 search">
                <input type="text" class="search__input" placeholder="Введите название товара">
            </div>
            <div class="col-md-12">
                <select v-model="selected_category" class="form-control" @change="selectCategory">
                    <option value="noselect" selected="selected">Выбрать товар</option>
                    <option :value="category" v-for="category in categories">{{category.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-9"></div>
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
                options: {},
                selected_category: 'noselect',
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
                    if (item.type === 'numeric' || item.type === 'string') {
                        self.$set(self.options, item.id, null);
                    } else if (item.type === 'boolean') {
                        self.$set(self.options, item.id, false);
                    }
                });
            }
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
    }
</style>
