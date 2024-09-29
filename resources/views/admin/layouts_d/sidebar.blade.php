@php
    $settings = DB::table('settings')->first();
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ $settings->site_name }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @yield('dashboard')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-home-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M10 12h4v4h-4z" /></svg>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.industry.index') }}"
                        class="nav-link {{ Request::routeIs('admin.industry.index') ? 'active' : '' }}">
                        <i class="fa fa-building"></i>
                        {{ __('Industry') }}
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.location.index') }}"
                        class="nav-link {{ Request::routeIs('admin.location.index') ? 'active' : '' }}">
                        <i class="fa fa-location-dot"></i>
                        {{ __('Location') }}
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.investment.index') }}"
                        class="nav-link {{ Request::routeIs('admin.investment.index') ? 'active' : '' }}">
                        <i class="fa fa-dollar"></i>
                        {{ __('Investment') }}
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.franchises.index') }}"
                        class="nav-link {{ Request::routeIs('admin.franchises.index') ? 'active' : '' }} @yield('franchises_create')">
                        <i class="fa fa-file"></i>
                        {{ __('All Listing') }}
                    </a>
                </li> --}}
                {{-- <li class="nav-item @yield('blogDropdown')">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-file-pen"></i>
                        <p> Blog <i class="fas fa-angle-left right"></i> </p>
                    </a>
                    <ul class="nav nav-treeview @yield('blockDropdownMenu')">
                        @if (Auth::user()->can('admin.blog-category.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.blog-category.index') }}" class="nav-link @yield('blog-category')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Blog Category</p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->can('admin.blog-post.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.blog-post.index') }}" class="nav-link  @yield('blog-post')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Blog Post</p>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>

                @if (Auth::user()->can('admin.category.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.category.index') }}" class="nav-link @yield('category')">
                            <i class="fa fa-address-book"></i>
                            {{ __('Category') }}
                        </a>
                    </li>
                @endif

                @if (Auth::user()->can('admin.subcategory.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.subcategory.index') }}" class="nav-link @yield('subcategory')">
                            <i class="fa fa-address-book"></i>
                            {{ __('Sub Category') }}
                        </a>
                    </li>
                @endif


                @if (Auth::user()->can('admin.contact.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.contact.index') }}" class="nav-link  @yield('contact')">
                            <i class="fa fa-address-book"></i>
                            {{ __('Contact') }}
                        </a>
                    </li>
                @endif

                @if (Auth::user()->can('admin.faq.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.faq.index') }}" class="nav-link @yield('faq')">
                            <i class="fa fa-question"></i>
                            {{ __('Faq') }}
                        </a>
                    </li>
                @endif

                @if (Auth::user()->can('admin.cpage.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.cpage.index') }}" class="nav-link  @yield('cpage')">
                            <i class=" fa fa-book"></i>
                            {{ __('Custom page') }}
                        </a>
                    </li>
                @endif 
                --}}

                {{-- <li class="nav-item">
                    <a href="{{ route('admin.cpage.index') }}"
                        class="nav-link {{ Request::routeIs('admin.cpage.index') ? 'active' : '' }} @yield('cpage_create')">
                        <i class=" fa fa-award"></i>
                        {{ __('Brand') }}
                    </a>
                </li> --}}

                {{-- @if (Auth::user()->can('admin.brand.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.brand.index') }}" class="nav-link  @yield('brand')">
                            <i class=" fa fa-award"></i>
                            {{ __('Brand') }}
                        </a>
                    </li>
                @endif --}}

                {{--

                <li class="nav-item ">
                    <a href="javascript:;" class="nav-link ">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Newsletter
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.newsletter.list') }}"
                                class="nav-link @yield('newsletter')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Email List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Send Mail</p>
                            </a>
                        </li>

                    </ul>
                </li> --}}


                {{-- @if (Auth::user()->can('admin.customer.index')) --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.customer.index') }}" class="nav-link @yield('customer')">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                            <p>{{ __('Customers') }}</p>
                        </a>
                    </li>
                {{-- @endif --}}

                {{-- @if (Auth::user()->can('admin.staff.index')) --}}
                <li class="nav-item">
                    <a href="{{ route('admin.staff.index') }}" class="nav-link @yield('staff')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M15 19l2 2l4 -4" /></svg>
                        <p>{{ __('User') }}</p>
                    </a>
                </li> 
                {{-- @endif --}}

                {{-- @if (Auth::user()->can('admin.notification.index'))
                <li class="nav-item">
                    <a href="{{ route('admin.notification.index') }}" class="nav-link @yield('notification')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-bell-ringing"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17.451 2.344a1 1 0 0 1 1.41 -.099a12.05 12.05 0 0 1 3.048 4.064a1 1 0 1 1 -1.818 .836a10.05 10.05 0 0 0 -2.54 -3.39a1 1 0 0 1 -.1 -1.41z" /><path d="M5.136 2.245a1 1 0 0 1 1.312 1.51a10.05 10.05 0 0 0 -2.54 3.39a1 1 0 1 1 -1.817 -.835a12.05 12.05 0 0 1 3.045 -4.065z" /><path d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z" /><path d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z" /></svg>
                        <p>{{ __('Notifications') }}</p>
                    </a>
                </li>
                @endif

                @if (Auth::user()->can('admin.alarm.index') || Auth::user()->can('admin.defcon-level.index'))
                <li class="nav-item @yield('alarm_menu') ">
                    <a href="{{ route('admin.settings') }}" class="nav-link ">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alarm"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M12 10l0 3l2 0" /><path d="M7 4l-2.75 2" /><path d="M17 4l2.75 2" /></svg>
                        <p>Alarm <i class="fas fa-angle-left right"></i></p>
                    </a>

                    <ul class="nav nav-treeview @yield('alarm_menu')">
                        @if (Auth::user()->can('admin.defcon-level.index'))
                        <li class="nav-item">
                            <a href="{{ route('admin.defcon-level.index') }}" class="nav-link @yield('defcon_level')">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-list-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3.5 5.5l1.5 1.5l2.5 -2.5" /><path d="M3.5 11.5l1.5 1.5l2.5 -2.5" /><path d="M3.5 17.5l1.5 1.5l2.5 -2.5" /><path d="M11 6l9 0" /><path d="M11 12l9 0" /><path d="M11 18l9 0" /></svg>
                                {{ __('Defcon Level') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->can('admin.alarm.index'))
                        <li class="nav-item">
                            <a href="{{ route('admin.alarm.index') }}" class="nav-link @yield('alarm')">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alarm-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M7 4l-2.75 2" /><path d="M17 4l2.75 2" /><path d="M10 13h4" /><path d="M12 11v4" /></svg>
                                {{ __('Alarm') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif --}}

                {{-- <li class="nav-item @yield('location_menu')">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>Location<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->can('admin.country.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.country.index') }}" class="nav-link @yield('country')">
                                    <i class="fas fa-cog nav-icon"></i>
                                    <p>Country</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->can('admin.region.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.region.index') }}" class="nav-link @yield('region')">
                                    <i class="fas fa-globe nav-icon"></i>
                                    <p>Region</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->can('admin.city.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.city.index') }}" class="nav-link @yield('city')">
                                    <i class="fas fa-globe nav-icon"></i>
                                    <p>city</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li> --}}

                {{-- @if (Auth::user()->can('admin.settings.index') || Auth::user()->can('admin.backup-file.index'))
                <li class="nav-item @yield('settings_menu') ">
                    <a href="{{ route('admin.settings') }}" class="nav-link ">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.003 21c-.732 .001 -1.465 -.438 -1.678 -1.317a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c.886 .215 1.325 .957 1.318 1.694" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>
                        <p>Settings<i class="fas fa-angle-left right"></i></p>
                    </a>

                    <ul class="nav nav-treeview @yield('settings_menu')">
                        @if (Auth::user()->can('admin.settings.index'))
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.general') }}" class="nav-link @yield('general')">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                                <p>General Settings</p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->can('admin.backup-file.index'))
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.backup') }}" class="nav-link @yield('backup')">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 17v-6" /><path d="M9.5 14.5l2.5 2.5l2.5 -2.5" /></svg>
                                <p>Backup</p>
                            </a>
                        </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('admin.settings.language') }}" class="nav-link @yield('language')">
                                <i class="fas fa-globe nav-icon"></i>
                                <p>Language</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.Smtp.mail') }}" class="nav-link @yield('smtp')">
                                <i class="fas fa-envelope nav-icon"></i>
                                <p>SMTP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.Currency.index') }}" class="nav-link @yield('currency')">
                                <i class="fas fa-dollar-sign nav-icon"></i>
                                <p>Currency</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.MobileApp.index') }}"
                                class="nav-link @yield('mobile_app')">
                                <i class="fas fa-mobile nav-icon"></i>
                                <p>Mobile App Config</p>
                            </a>
                        </li>

                    </ul>
                </li>
                @endif --}}

                {{-- @if (Auth::user()->can('admin.settings.index')) --}}
                <li class="nav-item">
                    <a href="{{ route('admin.settings.general') }}" class="nav-link @yield('general')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                        <p>General Settings</p>
                    </a>
                </li>
                {{-- @endif --}}
                {{-- @if (Auth::user()->can('admin.backup-file.index')) --}}
                <li class="nav-item">
                    <a href="{{ route('admin.settings.backup') }}" class="nav-link @yield('backup')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 17v-6" /><path d="M9.5 14.5l2.5 2.5l2.5 -2.5" /></svg>
                        <p>Backup</p>
                    </a>
                </li>
                {{-- @endif --}}

                {{-- @if (Auth::user()->can('admin.user.index')) --}}
                {{-- <li class="nav-item"><a href="{{ route('admin.user.index') }}"
                        class="nav-link @yield('admin-user')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" /><path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>
                        <p>{{ __('Admin User') }}</p>
                    </a>
                </li> --}}
                {{-- @endif --}}

                {{-- @if (Auth::user()->can('admin.role.index'))
                <li class="nav-item"><a href="{{ route('admin.roles.index') }}"
                        class="nav-link @yield('admin-roles')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>
                        <p>{{ __('Admin Roles') }}</p>
                    </a>
                </li>
                @endif --}}

                {{-- <li class="nav-item"><a href="{{ route('admin.permissions.index') }}"
                        class="nav-link @yield('admin-permissions')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-lock-access"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M8 11m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" /><path d="M10 11v-2a2 2 0 1 1 4 0v2" /></svg>
                        {{ __('Admin permissions') }}</a>
                    </li> 
                --}}


            </ul>
        </nav>
    </div>
</aside>
