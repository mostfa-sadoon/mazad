<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
       <div class="main-menu-content">
              <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                     <li class="nav-item active"><a href="{{route('admin.dashboard')}}"><i
                                          class="la la-mouse-pointer"></i><span class="menu-title"
                                          data-i18n="nav.add_on_drag_drop.main">{{__('admin/sidebar.main')}} </span></a>
                     </li>


                     <li class="nav-item  <?php if($active_links[0] == 'users')  echo 'open'; ?> "><a href=""><i
                                          class="la la-group"></i>
                                   <span class="menu-title"
                                          data-i18n="nav.dash.main">{{__('admin/sidebar.clients')}}</span>
                                   <span class="badge badge badge-success badge-pill float-right mr-2">{{\App\Models\Client::count()}}
                                   </span>
                            </a>
                            <ul class="menu-content">
                                   <li class="<?php if($active_links[1] === 'showusers') echo 'active'; ?> "><a
                                                 class="menu-item" href="{{route('dashboard.users.index')}}"
                                                 data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                   </li>
                            </ul>
                     </li>





                     <li class="nav-item  <?php if($active_links[0] == 'auctions')  echo 'open'; ?> "><a href="">
                                   <i class="la la-map-marker"></i>
                                   <span class="menu-title"
                                          data-i18n="nav.dash.main">{{__('admin/sidebar.auctions')}}</span>
                                   <span class="badge badge badge-success badge-pill float-right mr-2">{{\App\Models\Auction::count()}}
                                   </span>
                            </a>
                            <ul class="menu-content">
                                   <li class="<?php if($active_links[1] === 'showauctions') echo 'active'; ?> "><a
                                                 class="menu-item" href="{{route('admin.auctions')}}"
                                                 data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                   </li>
                            </ul>
                     </li>





                     <li class="nav-item  <?php if($active_links[0] == 'categories')  echo 'open'; ?> "><a href="">
                            <i class="ft-list "></i>
                                   <span class="menu-title"
                                          data-i18n="nav.dash.main">{{__('admin/sidebar.categories')}}</span>
                                   <span class="badge badge badge-success badge-pill float-right mr-2">{{\App\Models\Category::count()}}
                                   </span>
                            </a>
                            <ul class="menu-content">
                                   <li class="<?php if($active_links[1] === 'showcategories') echo 'active'; ?> "><a
                                                 class="menu-item" href="{{route('admin.categories')}}"
                                                 data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                   </li>
                                   <li class="<?php if($active_links[1] === 'addcategories') echo 'active'; ?>"><a
                                                 class="menu-item" href="{{route('admin.categories.create')}}"
                                                 data-i18n="nav.dash.crypto">{{__('admin/sidebar.add_cat')}}</a>
                                   </li>
                            </ul>
                     </li>




                     <li class="nav-item  <?php if($active_links[0] == 'countries')  echo 'open'; ?> "><a href="">
                                   <i class="la la-map-marker"></i>
                                   <span class="menu-title"
                                          data-i18n="nav.dash.main">{{__('admin/sidebar.countries')}}</span>
                                   <span class="badge badge badge-success badge-pill float-right mr-2">{{\App\Models\Country::count()}}
                                   </span>
                            </a>
                            <ul class="menu-content">
                                   <li class="<?php if($active_links[1] === 'showcountries') echo 'active'; ?> "><a
                                                 class="menu-item" href="{{route('admin.countries')}}"
                                                 data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                   </li>
                                   <li class="<?php if($active_links[1] === 'addcountries') echo 'active'; ?>"><a
                                                 class="menu-item" href="{{route('admin.countries.create')}}"
                                                 data-i18n="nav.dash.crypto">{{__('admin/sidebar.add_country')}}</a>
                                   </li>
                            </ul>
                     </li>





                     <li class="nav-item  <?php if($active_links[0] == 'cities')  echo 'open'; ?> "><a href="">
                                   <i class="la la-map-marker"></i>
                                   <span class="menu-title"
                                          data-i18n="nav.dash.main">{{__('admin/sidebar.cities')}}</span>
                                   <span class="badge badge badge-success badge-pill float-right mr-2">{{\App\Models\City::count()}}
                                   </span>
                            </a>
                            <ul class="menu-content">
                                   <li class="<?php if($active_links[1] === 'showcities') echo 'active'; ?> "><a
                                                 class="menu-item" href="{{route('admin.cities')}}"
                                                 data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                   </li>
                                   <li class="<?php if($active_links[1] === 'addcities') echo 'active'; ?>"><a
                                                 class="menu-item" href="{{route('admin.cities.create')}}"
                                                 data-i18n="nav.dash.crypto">{{__('admin/sidebar.add_city')}}</a>
                                   </li>
                            </ul>
                     </li>

                      <li class="nav-item  <?php if($active_links[0] == 'recognitions')  echo 'open'; ?> "><a href="">
                                   <i class="la la-location-arrow"></i>
                                   <span class="menu-title"
                                          data-i18n="nav.dash.main">{{__('admin/sidebar.packages')}}</span>
                                   <span class="badge badge badge-success badge-pill float-right mr-2">{{\App\Models\Recognition::count()}}
                                   </span>
                            </a>
                            <ul class="menu-content">
                                   <li class="<?php if($active_links[1] === 'showrecognitions') echo 'active'; ?> "><a
                                                 class="menu-item" href="{{route('admin.recognitions')}}"
                                                 data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                   </li>
                                   <li class="<?php if($active_links[1] === 'addrecognitions') echo 'active'; ?>"><a
                                                 class="menu-item" href="{{route('admin.recognitions.create')}}"
                                                 data-i18n="nav.dash.crypto">{{__('admin/sidebar.add_package')}}</a>
                                   </li>
                            </ul>
                     </li>





                     <li class="nav-item  <?php if($active_links[0] == 'slider')  echo 'open'; ?> "><a href="">
                                   <i class="la la-sliders"></i>
                                   <span class="menu-title"
                                          data-i18n="nav.dash.main">{{__('admin/sidebar.sliders')}}</span>
                                   <span class="badge badge badge-success badge-pill float-right mr-2">{{\App\Models\Slider::count()}}
                                   </span>
                            </a>
                            <ul class="menu-content">
                                   <li class="<?php if($active_links[1] === 'showslider') echo 'active'; ?> "><a
                                                 class="menu-item" href="{{route('admin.slider')}}"
                                                 data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                   </li>
                                   <li class="<?php if($active_links[1] === 'addslider') echo 'active'; ?>"><a
                                                 class="menu-item" href="{{route('admin.slider.create')}}"
                                                 data-i18n="nav.dash.crypto">{{__('admin/sidebar.add_slider')}}</a>
                                   </li>
                            </ul>
                     </li>

                     <li class="nav-item  <?php if($active_links[0] == 'bannars')  echo 'open'; ?> "><a href="">
                                   <i class="la la-sliders"></i>
                                   <span class="menu-title"
                                          data-i18n="nav.dash.main">{{__('admin/sidebar.panars')}}</span>
                                   <span class="badge badge badge-success badge-pill float-right mr-2">{{\App\Models\Banner::count()}}
                                   </span>
                            </a>
                            <ul class="menu-content">
                                   <li class="<?php if($active_links[1] === 'showbanners') echo 'active'; ?> "><a
                                                 class="menu-item" href="{{route('admin.banners')}}"
                                                 data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                   </li>
                                   {{-- <li class="<?php if($active_links[1] === 'addbanners') echo 'active'; ?>"><a
                                    class="menu-item" href="{{route('admin.banners.create')}}"
                                    data-i18n="nav.dash.crypto">{{__('admin/sidebar.add_banner')}}</a>
                                   </li> --}}
                            </ul>
                     </li>


                     <li class="nav-item  <?php if($active_links[0] == 'aboutus')  echo 'open'; ?> "><a href="{{route('admin.aboutus.edit')}}">
                        <i class="ft-list "></i>
                               <span class="menu-title"
                                      data-i18n="nav.dash.main">{{__('admin/sidebar.about_us')}}</span>
                               </span>
                        </a>
                    </li>


                    <li class="nav-item  <?php if($active_links[0] == 'socialmedia')  echo 'open'; ?> "><a href="{{route('admin.socialmedia')}}">
                        <i class="ft-list "></i>
                               <span class="menu-title"
                                      data-i18n="nav.dash.main">{{__('admin/sidebar.socialmedia')}}</span>
                               </span>
                        </a>
                    </li>

                    <li class="nav-item  <?php if($active_links[0] == 'terms')  echo 'open'; ?> "><a href="{{route('admin.terms.edit')}}">
                        <i class="ft-list "></i>
                               <span class="menu-title"
                                      data-i18n="nav.dash.main">{{__('admin/sidebar.terms')}}</span>
                               </span>
                        </a>
                    </li>


                    <li class="nav-item  <?php if($active_links[0] == 'privacy')  echo 'open'; ?> "><a href="{{route('admin.privacy.edit')}}">
                        <i class="ft-list "></i>
                               <span class="menu-title"
                                      data-i18n="nav.dash.main">{{__('admin/sidebar.privacy')}}</span>
                               </span>
                        </a>
                    </li>

                    <li class="nav-item  <?php if($active_links[0] == 'logo')  echo 'open'; ?> "><a href="{{route('admin.Logo.edit')}}">
                        <i class="ft-list "></i>
                               <span class="menu-title"
                                      data-i18n="nav.dash.main">{{__('admin/sidebar.logo')}}</span>
                               </span>
                        </a>
                    </li>


                    <li class="nav-item  <?php if($active_links[0] == 'ContactUs')  echo 'open'; ?> "><a href="{{route('admin.ContactUs.edit')}}">
                        <i class="ft-list "></i>
                               <span class="menu-title"
                                      data-i18n="nav.dash.main">{{__('admin/sidebar.ContactUs')}}</span>
                               </span>
                        </a>
                    </li>

                    <li class="nav-item  <?php if($active_links[0] == 'cities')  echo 'open'; ?> "><a href="">
                        <i class="ft-list "></i>
                        <span class="menu-title"
                               data-i18n="nav.dash.main">{{__('admin/sidebar.home_section')}}</span>

                        </span>
                      </a>
                        <ul class="menu-content">
                                <li class="<?php if($active_links[1] === 'showcities') echo 'active'; ?> "><a
                                            class="menu-item" href="{{route('admin.HomeSection.index')}}"
                                            data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                </li>
                                <li class="<?php if($active_links[1] === 'addsection') echo 'active'; ?>"><a
                                            class="menu-item" href="{{route('admin.HomeSection.create')}}"
                                            data-i18n="nav.dash.crypto">{{__('admin/sidebar.add_home_section')}}</a>
                                </li>
                        </ul>
                   </li>


               {{--hallo world--}}



                        <li class="nav-item  <?php if($active_links[0] == 'cities')  echo 'open'; ?> "><a href="">
                            <i class="ft-list "></i>
                            <span class="menu-title"
                                data-i18n="nav.dash.main">{{__('admin/sidebar.quetions')}}</span>

                            </span>
                            </a>
                            <ul class="menu-content">
                                <li class="<?php if($active_links[1] === 'showcities') echo 'active'; ?> "><a
                                            class="menu-item" href="{{route('admin.Quetion.index')}}"
                                            data-i18n="nav.dash.ecommerce"> {{__('admin/sidebar.show_all')}} </a>
                                </li>
                                <li class="<?php if($active_links[1] === 'addsection') echo 'active'; ?>"><a
                                            class="menu-item" href="{{route('admin.Quetion.create')}}"
                                            data-i18n="nav.dash.crypto">{{__('admin/sidebar.add_quetion')}}</a>
                                </li>
                            </ul>
                        </li>





              </ul>
       </div>
</div>
