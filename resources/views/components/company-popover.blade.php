@props(['id', 'name', 'category','address'=>null,'email'=>null, 'number'=>null, 'website'=>null])
<div data-popover id="popover-company-profile" role="tooltip" @mousedown.outside="openCompany=false" x-bind:class="openCompany === {{ $id }} ? 'opacity-100 pointer-events-auto':'opacity-0 pointer-events-none'" class="opacity-0 pointer-events-none absolute  z-10   inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm w-80 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
    <div class="p-3" >
        <div class="flex">

            <div class="mr-3 shrink-0 text-primary">
                <box-icon name='buildings' type='solid' color="currentColor" size="md"></box-icon>
            </div>
            <div>
                <p class="mb-1 text-base font-semibold leading-none text-gray-900 dark:text-white">
                    <p class="font-medium capitalize decoration-none   text-primary">{{$name}}</p>
                </p>
                <p class="mb-3 text-sm font-normal">
                    {{$category}}
                </p>
                <ul class="text-sm">
                    @isset($address)
                    <li class="flex items-center mb-2">
                        <span class="mr-3 font-semibold text-primary">
                        <box-icon name='map' color="currentColor" ></box-icon>
                        </span>
                        <p >{{$address}}</p>
                    </li>
                    @endisset
                    @isset($website)
                    <li class="flex items-center mb-2">
                        <span class="mr-3 font-semibold text-primary ">
                            <box-icon name='link' color="currentColor" ></box-icon>
                            </span>
                        <p >{{$website}}</p>
                    </li>
                    @endisset
                    @isset($email)
                    <li class="flex items-center mb-2">
                        <span class="mr-3 font-semibold text-primary">
                            <box-icon name='envelope' color="currentColor" ></box-icon>
                        </span>
                        <p >{{$email}}</p>
                    </li>
                    @endisset
                    @isset($number)
                    <li class="flex items-center mb-2">
                        <span class="mr-3 font-semibold text-primary">
                            <box-icon name='phone' color="currentColor" ></box-icon>
                        </span>
                        <p >{{$number}}</p>
                    </li>
                    @endisset
                </ul>
            </div>
        </div>
    </div>
    <div data-popper-arrow></div>
</div>
