<x-user-layout>

    <div class="py-6 mx-4 md:mx-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-12">
                <div class="font-medium text-lg mb-2">Project {{$pro->id}}</div>
                    <div class="flex  justify-between w-full flex-wrap gap-y-4">
                        <div class="">Price Range: {{$pro->price_range->name}}</div>
                        <div class="">Approximative area: {{$pro->getAttribute('aprox-area')}}</div>
                        <div class="">Deadline: {{$pro->deadline}}</div>
                        <div ><a class="link text-primary  no-underline" href="{{url()->full()}}/details">view more</a></div>

                    </div>
            </div>
            <div class="md:flex justify-between justify-self">

                    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 md:mb-0  md:w-2/3 md:mr-12">
                        <h3 class="font-medium text-xl mb-8">Sketch</h3>

                        <div class="carousel w-full">
                            <div id="slide1" class="carousel-item relative w-full">
                              <img src="https://images.unsplash.com/photo-1599420186917-468a49a78a63?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80"  height="00" className="w-full" />
                              <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                <a href="#slide4" class="btn btn-circle">❮</a>
                                <a href="#slide2" class="btn btn-circle">❯</a>
                              </div>
                            </div>
                        </div>








                    </div>

                    <div class=" md:w-1/3 min-h-48" >

                        <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg " x-data="{openCompany : false}">
                            <div class="flex w-full justify-between mb-6">
                            <h3 class="font-medium text-xl ">Offers</h3>
                            @if($pro->winner_company!==null)
                                <h4 class="capitalize text-sm font-medium  mb-2 text-gray-900">offer chosen</h4>
                            @elseif($pro->deadline < now())
                                    <h4 class="capitalize text-sm font-medium  mb-2 text-gray-900">sending closed</h4>
                            @else
                                    <h4 class="capitalize text-sm font-medium  mb-2 text-gray-900">ongoing</h4>
                            @endif
                            </div>
                            @if($pro->winner_company!==null)
                                <div  class="border-t py-2 realtive">
                                    <div class="flex justify-between">
                                        <h4 @click="openCompany = {{ $company->id }}" class="link font-medium capitalize  mb-4  text-primary no-underline">{{$company->user->name}}</h4>
                                        <a class="link text-primary no-underline "href="{{url()->full()}}/{{$company->id}}/company_file">company file</a>
                                    </div>
                                    <x-company-popover id="{{$company->id}}"  category="{{$company->category->name}}" name="{{$company->user->name}}" email="{{$company->contact_email}}" email="{{$company->contact_email}}" number="{{$company->contact_phone}}" address="{{$company->contact_address}}" website="{{$company->contact_website}}" x-on:click.away="openCompany = false"></x-company-popover>
                                    @if($company->offer->is_accurate)
                                        <p class=" capitalize text-sm font-medium  text-gray-600">Only Conceptual included</p>
                                    @else
                                        <p class=" capitalize text-sm font-medium  text-gray-600">Detail Design included</p>
                                    @endif
                                    <p class="text-primary mt-2 capitalize">offer value: {{$company->offer->value}}</p>
                                    <div class="mt-6 flex justify-evenly">
                                            <a href="{{url()->full()}}/{{$company->id}}/contract_file"><button class="btn btn-primary btn-sm text-sm" >contract file</button></a>
                                            <button class="btn  btn-primary btn-sm text-sm">sketch</button>
                                    </div>
                                </div>
                            @elseif(count($companies)>0)
                                @foreach($companies as $company)

                                    <div  class="border-t py-2 realtive">
                                        <div class="flex justify-between">
                                            <h4 @click="openCompany = {{ $company->id }}" class="link font-medium capitalize  mb-4  text-primary no-underline">{{$company->user->name}}</h4>
                                            <a class="link text-primary no-underline "href="{{url()->full()}}/{{$company->id}}/company_file">company file</a>
                                        </div>
                                        <x-company-popover id="{{$company->id}}"  category="{{$company->category->name}}" name="{{$company->user->name}}" email="{{$company->contact_email}}" email="{{$company->contact_email}}" number="{{$company->contact_phone}}" address="{{$company->contact_address}}" website="{{$company->contact_website}}" x-on:click.away="openCompany = false"></x-company-popover>
                                        @if($company->offer->is_accurate)
                                            <p class=" capitalize text-sm font-medium  text-gray-600">Only Conceptual included</p>
                                        @else
                                            <p class=" capitalize text-sm font-medium  text-gray-600">Detail Design included</p>
                                        @endif
                                        <p>offer value: {{$company->offer->value}}</p>
                                        <div class="mt-6 flex justify-evenly">
                                            <a href="{{url()->full()}}/{{$company->id}}/contract_file"><button class="btn btn-primary btn-sm text-sm" >contract file</button></a>
                                            <button class="btn  btn-primary btn-sm text-sm">sketch</button>
                                        </div>
                                        <div class="mt-4 flex justify-center">
                                        <a href="{{url()->full()}}/{{$company->id}}/choose_offer"><button class="btn btn-wide  btn-accent btn-sm text-sm">Choose this offer</button></a>

                                        </div>
                                    </div>
                                @endforeach
                            @else
                                    <p class="text-primary">no offers at the moment</p>
                            @endif
                    </div>

            </div>






        </div>
    </div>


</x-user-layout>
