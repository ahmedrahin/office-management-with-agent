@extends('agent.layout.template')

@section('page-title') Your Dashboard @endsection

@section('body-content')

    <style>
        .text-truncate {
            font-weight: 600;
        }
    </style>

    <!-- start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
                        
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Your Dashboard</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Student You Added</p>
                                    <h4 class="mb-2">{{ App\Models\Registation::where('user_type','agent')->where('agent_id',auth()->user()->id)->count() }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-user-star-line font-size-24"></i>  
                                    </span>
                                </div>
                            </div>                                            
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Job Inquiry Person You Added</p>
                                    <h4 class="mb-2">{{ App\Models\JobInquiry::where('user_type','agent')->where('agent_id',auth()->user()->id)->count() }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>  
                                    </span>
                                </div>
                            </div>                                              
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Tourist You Added</p>
                                    <h4 class="mb-2">{{ App\Models\Tourist::where('user_type','agent')->where('agent_id',auth()->user()->id)->count() }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>  
                                    </span>
                                </div>
                            </div>                                              
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Cost By Student</p>
                                    <h4 class="mb-2">৳{{ App\Models\Registation::where('user_type','agent')->where('agent_id',auth()->user()->id)->sum('total_cost') }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <i class="mdi mdi-currency-usd font-size-24"></i>  
                                    </span>
                                </div>
                            </div>                                              
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Cost By Job Inquiry Person</p>
                                    <h4 class="mb-2">৳{{ App\Models\JobInquiry::where('user_type','agent')->where('agent_id',auth()->user()->id)->sum('total_cost') }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="mdi mdi-currency-usd font-size-24"></i>  
                                    </span>
                                </div>
                            </div>                                              
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Cost By Tourist</p>
                                    <h4 class="mb-2">৳{{ App\Models\Tourist::where('user_type','agent')->where('agent_id',auth()->user()->id)->sum('total_cost') }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="mdi mdi-currency-usd font-size-24"></i>  
                                    </span>
                                </div>
                            </div>                                              
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div>
            </div>

        </div>
    </div>
    <!-- End Page-content -->

@endsection
          
         
@section('page-script')


@endsection

         

        
