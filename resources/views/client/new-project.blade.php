<x-nonav-layout data-theme="mytheme" >
    <div class="mx-2 md:mx-24 min-h-screen  relative" x-data="{step: 1}">
        <ul class="steps w-full h-1/4">
            <li x-bind:class="step>=1 ?'step step-primary': 'step'">Plot Informations</li>
            <li x-bind:class="step>=2 ?'step step-primary': 'step'">Desired Spaces</li>
            <li x-bind:class="step>=3 ?'step step-primary': 'step'">Competitors</li>
            <li x-bind:class="step>=4 ?'step step-primary': 'step'">Finishing</li>
        </ul>
        <form class="mt-12 3/4" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="step" x-show="step==1">
                <!--krooky plot-->
                <div class="form-control w-full max-w-xs mb-6" x-bind:x-show=>
                    <label class="label" for="milkyah_file">
                    <span class="label-text font-medium">Milkyah Plot</span>
                    </label>
                    <input name="milkyah_file" type="file" class="file-input file-input-bordered file-input-primary w-full max-w-xs" />
                </div>

                <!--krooky plot-->
                <div class="form-control w-full max-w-xs mb-6">
                    <label class="label" for="krooky_file">
                    <span class="label-text font-medium">Plot Krooky</span>
                    </label>
                    <input name="krooky_file" type="file" class="file-input file-input-bordered file-input-primary w-full max-w-xs" />
                </div>

                <!--krooky plot-->
                <div class="form-control w-full max-w-xs mb-6">
                    <label class="label" for="owner_id_file">
                    <span class="label-text font-medium">Owner id</span>
                    </label>
                    <input name="owner_id_file" type="file" class="file-input file-input-bordered file-input-primary w-full max-w-xs" />
                </div>
            </div>

            <div class="step" x-show="step==2" x-data="{inputs: [],inputsN:1}">
                <div class="flex justify-between mb-16 flex-wrap gap-y-6 gap-x-2 ">
                    <input required class="input input-bordered input-primary" placeholder="Space Name"  name="spaceName0" type="text">
                    <input required class="input input-bordered input-primary text-center basis-full sm:basis-1/2" placeholder="Describe your demands to the competitors" name="spaceDesc0" type="text">
                    <input required class="input input-bordered input-primary " placeholder="aproximative area" name="spaceArea0" type="number">
                    <select required class="select select-bordered select-primary"   name="spaceFloor0">
                        <option selected>floor number</option>
                        <option  value="0">ground floor</option>
                        <option  value="1">first</option>
                        <option value="2">second</option>
                        <option value="3">third</option>
                        <option value="4">fourth</option>
                        <option value="5">fifth</option>
                        <option value="6">sexth</option>
                        <option value="7">seventh</option>
                    </select>
                    <button disabled class="btn btn-error opacity-0"  >remove</button>
                    </div>

                <template x-for="(id ,index) in inputs" x-bind:key="id">
                    <div class="flex justify-between mb-16 flex-wrap  gap-y-6 gap-x-2">
                    <input class="input input-bordered input-primary" required placeholder="Space Name"  x-bind:name="'spaceName'+(index+1)" type="text">
                    <input class="input input-bordered input-primary basis-1/2  text-center " required placeholder="Describe your demands to the competitors" x-bind:name="'spaceDesc'+(index+1)" type="text">
                    <input class="input input-bordered input-primary" required placeholder="aproximative area" x-bind:name="'spaceArea'+(index+1)" type="number">
                    <select class="select select-bordered select-primary" required  x-bind:name="'spaceFloor'+(index+1)">
                        <option selected>floor number</option>
                        <option  value="0">ground floor</option>
                        <option  value="1">first</option>
                        <option value="2">second</option>
                        <option value="3">third</option>
                        <option value="4">fourth</option>
                        <option value="5">fifth</option>
                        <option value="6">sexth</option>
                        <option value="7">seventh</option>
                    </select>
                    <button class="btn btn-error" type="button" x-on:click="inputsN--,removed=inputs.indexOf(id),console.log(removed),inputs.splice(removed, 1)">remove</button>
                    </div>
                </template>
                <input type="hidden" name="inputsN" x-model="inputsN">
                <button class="btn btn-success  mt-12 mb-12 md float-right right-0" type="button"   @click="inputsN++,inputs.length>0 ? inputs.push(Math.max.apply(null,inputs)+1) : inputs.push(0)" >add</button>

            </div>

            <div class="step" x-show="step==3">
                @foreach ($categories as $cat)
                <div class="form-control shadow rounded-xl p-4 mb-6 bg-neutral">
                    <div class="form-control">
                        <label class="label cursor-pointer">
                          <span class="label-text font-medium text-xl">{{$cat->name}}</span>
                          <input name="categories[{{$cat->id}}]"  type="checkbox" checked="checked" class="checkbox checkbox-primary"/>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="step mt-6 h-4/6 flex justify-center absolute w-full" x-show="step==4">

                <div class="flex flex-col justify-evenly w-96">
                <!--price range-->
                <div >
                <label for="price-range" class="label">
                    <span class="label-text font-medium ">Price Range</span>
                  </label>
                <select name="price-range" class="select select-primary select-bordered w-full">
                    @foreach($priceRanges as $pr)
                    <option value="{{$pr->id}}">{{$pr->name}}</option>
                    @endforeach
                </select>
                </div>
                <!--deadline-->
                <div>
                <label for="deadline" class="label">
                    <span class="label-text font-medium">Deadline</span>
                  </label>
                <input name="deadline" class="input input-primary input-bordered input-primary w-full" type="date">
                </div>

                <!--support omanian-->
                    <div >
                    <div class="flex mr-6 items-center mb-2">
                    <input name="support_omanian_firms" type="checkbox" class="checkbox checkbox-primary  mr-4"/>
                    <label for="support_omanian_firms" class="label">
                        <span class="label-text font-medium">Support omanian firms</span>
                      </label>
                    </div>
                <!--accept terms-->
                <div class="flex mr-6 items-center mb-6">
                    <input required type="checkbox" class="toggle toggle-primary mr-4"/>
                    <label for="support_omanian_firms" class="label">
                        <span class="label-text font-medium">I agree to the <span class="link">terms and conditions</span></span>
                    </label>
                </div>
                <input type="submit" value="Launch the competetion" class="btn btn-accent btn-wide w-full mt-n-4">
                </div>


                </div>
            </div>

            <div class="join fixed bottom-12">
                <button type="button" class="btn btn-primary btn-outline w-24 join-item"  @click="step > 1 ? step-- : ''">Previous</button>
                <button type="button" class="btn btn-primary btn-outline w-24 join-item" @click="step <4 ? step++ : ''">Next</button>
            </div>

        </form>
    </div>
</x-nonav-layout>

