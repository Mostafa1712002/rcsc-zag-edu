<section class="sign-in">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <p class="sign-head"><i class="fas fa-arrow-right"></i>@lang('site.login')</p>
                <div class="sign-card bg-card-dark p-5 rounded">
                    <form class="l-custom" wire:submit.prevent='store' >
                        @csrf
                        <div class="mb-2">
                            <label for="Fname" class="form-label float-end">@lang('validation.attributes.national_id')</label>
                            <input wire:model='national_id' type="text"  class="form-control form-control-3  @error('national_id') is-invalid @enderror" />
                            @error('national_id') <p class="text-danger">{{$message}}</p> @enderror
                        </div>



                        <div class="d-grid gap-2">

                            <button type="submit" class="btn btn-2 px-3 mt-2">@lang('site.login')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
