<div class="col-lg-7 col-md-7">
        {{-- <div class="input-group mb-3">

            <input
                type="text"
                wire:model.defer='search_term'
                x-data
                x-on:keydown.enter="$('#filter-search-btn').trigger('click')"
                wire:keydown.debounce.50ms="$emit('home-search-changed',$event.target.value)" value='{{request('search_term')}}' class="form-control form-control-lg form-place-size" placeholder="@lang('site.search_for_what_you_need')"/>
            <button x-data x-on:click="$('#filter-search-btn').trigger('click')" type="button" class="input-group-text btn-1">
                <i class="fas fa-search"></i>
            </button>
        </div> --}}
</div>
