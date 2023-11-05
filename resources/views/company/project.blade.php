<x-company-layout>

    <div class="py-6 mx-4 md:mx-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
            <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-12">
                <div class="font-medium text-lg mb-2">Project {{$pro->id}}</div>
                    <div class="flex  justify-between w-full flex-wrap gap-y-4">
                        <div class="">Client from: {{$pro->user->client->province->name}}</div>
                        <div class="">Price Range: {{$pro->price_range->name}}</div>
                        <div class="">Approximative area: {{$pro->getAttribute('aprox-area')}}</div>
                        <div class="">Deadline: {{$pro->deadline}}</div>
                    </div>
            </div>
            <div class="md:flex justify-between justify-self">

                    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 md:mb-0  md:w-2/3 md:mr-12">
                        <h3 class="font-medium text-xl mb-8">Spaces</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>space</th>
                                    <th>description</th>
                                    <th>approximative area</th>
                                    <th>floor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pro->spaces->toQuery()->orderBy('floor')->get() as $space)
                                <tr class="hover">
                                    <td>{{$space->name}}</td>
                                    <td>{{$space->description}}</td>
                                    <td>{{$space->total_area}}</td>
                                    @if($space->floor === 0)
                                    <td>groud floor</td>
                                    @else
                                    <td>{{$space->floor}} floor</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class=" md:w-1/3 min-h-48">
                        <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <h3 class="font-medium text-xl mb-8">Documents</h3>
                            <div><a class="link " href="{{url()->full()}}/plot">download land plot</a></div>
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6 ">
                            <div class="flex w-full justify-between mb-6">
                            <h3 class="font-medium text-xl ">Offers</h3>
                            @if(!isset($offer->contract_file))
                            <h4 class="capitalize text-sm font-medium  mb-2 text-gray-90">not sent</h4>
                            </div>
                            <div>
                                <div class="flex justify-evenly mb-4"><a href="{{url()->full()}}/send-offer"><button class="btn btn-secondary">send my offer</button></a><button class="btn btn-error">regret</button></div>
                                <div><button class="btn btn-wide btn-accent text  w-full">contenue sketching</button></div>
                            </div>
                            @else
                            <h4 class="capitalize text-sm font-medium  mb-2 text-gray-900">sent</h4>
                            </div>
                            <div>
                                @if($offer->is_accurate)
                                <p class=" capitalize text-sm font-medium mb-4 text-gray-600">Only Conceptual included</p>
                                @else
                                <p class=" capitalize text-sm font-medium mb-4 text-gray-600">Detail Design included</p>
                                @endif
                                <a class="link" href="{{url()->full()}}/contract_file">download contract file</a>
                            </div>
                            @endif
                    </div>

            </div>






        </div>
    </div>


</x-company-layout>
