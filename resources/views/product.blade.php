@extends("layout.base")


@section('title')Products @endsection
@section('keywords')Adroit Products, Adroitus products @endsection
@section('description') Adroit Products, Adroitus products @endsection


@section('body')
<style>
    [v-cloak] {display: none}
</style>

<input type="hidden" id="category" value="{{ $category }}">
<section class="inner_page_section_padding" id="product-page-app" v-cloak>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-auto">
                    <div class="pb-4 text-right d-lg-none">
                        <a href="#" class="btn filter_btn" onclick="toggleFilter();"><i class="fas fa-filter"></i> Filter</a>
                    </div>
                    <div class="filter_wrapper">
                        <div class="text-right pb-4 d-lg-none">
                            <button class="btn close_btn" onclick="toggleFilter();"><i class="fas fa-times"></i></button>
                        </div>
                        <h3>Filter</h3>
                        <hr class="mt-1">
                        <form method="get" action="/products">
                            <label
                                class="radio_switch_label mb-3 d-flex align-items-center justify-content-between">Best
                                Seller<input type="checkbox" class="radio_switch_input" name="bestSeller" value="yes" v-model="formData.bestSeller" />
                                <div class="d-inline-block">
                                    <div></div>
                                </div>
                            </label>

                            <hr>
                                <h5>Categories</h5>
                                <label class="checkBox_style" v-for="item in categoryList">
                                    <input type="checkbox" name="category[]" :value="item.id" v-model="formData.categories"/>
                                    <% item.title %>
                                    <span></span>
                                </label>
                            <hr>
                            <h5 v-if="subCategoryList.length > 0">Sub Categories</h5>
                            <label class="checkBox_style" v-for="item in subCategoryList">
                                <input type="checkbox" :value="item.id" v-model="formData.subCategories" />
                                <% item.title %>
                                <span></span>
                            </label>
                            
                            <input type="hidden" name="pageNumber" value="1" id="pageNumber">
                            <button type="button" class="btn product_filter_btn" @click="filterResult()">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg">
                    <div class="product_list_cards mb-5">
                        <ul class="list-unstyled">
                            <li class="ease" v-for="item,index in productList">
                                <div class="product_card_wrapper row">
                                    <div class="col-md-4">
                                        <img :src="item.featuredImage" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="product_list_inner p_relative">
                                            <span class="d-inline-block bestTag" v-if="item.bestSeller">Best seller</span>
                                            <h2><% item.title %></h2>
                                            <p><small class="text-muted"><% item.categoryTitle %> / <% item.subCategoryTitle %></small></p>
                                            <div v-html="item.shortDescription">
                                            </div>
                                            <a :href="'/product/'+item.slug" class="btn product_more_btn">View More</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                                <li class="ease" v-if="productList.length <= 0">
                                    <div class="text-center">
                                        <h5 class="p-5">No Products to display</h5>
                                    </div>
                                </li>
                        </ul>
                    </div>

                    <input type="hidden" id="totalItems" value="{{ $products->total()}}">
                    <input type="hidden" id="perPageItems" value="{{ $products->perPage()}}">

                    <nav class="site_pagination">
                        <ul class="pagination justify-content-end">
                            <li class="page-item" v-if="currentPage > 1" @click="gotoPrevious()">
                                <span class="page-link">Previous</span>
                            </li>
                            <li class="page-item"  v-if="currentPage > 1"><a class="page-link" href="javascript:;">1</a></li>
                            <li class="page-item active">
                            <span class="page-link">
                                <% currentPage %>
                                <span class="sr-only">(current)</span>
                            </span>
                            </li>
                            <li class="page-item"  v-if="currentPage < lastPage"><a class="page-link" href="javascript:;"><% lastPage %></a></li>
                            <li class="page-item"  v-if="currentPage < lastPage"  @click="gotoNext()">
                                <a class="page-link" href="javascript:;">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- end of page body section -->

@endsection

@section('script')
<script type="text/javascript" src="/assets/js/product-page.js"></script>

@endsection