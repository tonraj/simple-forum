<div class="inner-sidebar d-none d-sm-block">
                <!-- Inner sidebar header -->
                <div class="inner-sidebar-header justify-content-center">
                    <a class="btn btn-primary has-icon btn-block" href="/ask_question">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Ask question
                    </a>
                </div>
                <div class=" p-0">
                    <div class="p-3 " data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: -16px;">
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" style="height: 100%;">
                                        <div class="simplebar-content" style="padding: 16px;">
                                            <nav class="nav nav-pills nav-gap-y-1 flex-column">

                                            @foreach ($categories as $name => $value)
                                                <a href="javascript:void(0)" class="nav-link nav-link-faded has-icon active mb-0">
                                                    {{$name}} 
                                                </a>
                                                <div class="nav-link nav-link-faded has-icon mt-0 p-2 pt-3">
                                                <ul>
                                                    @foreach ($value as $subcat)
                                                        <li><a href="/category/{{ $subcat[1] }}/{{ $subcat[0] }}">{{ $subcat[2] }}</a></li>
                                                    @endforeach
                                                </ul>
                                                </div>

                                                </optgroup>
                                            @endforeach
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Inner sidebar body -->
            </div>
            <!-- /Inner sidebar -->