<section class="sign-in">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <p class="sign-head"><i class="fas fa-arrow-right"></i> @lang('site.register')</p>
                <div class="sign-card bg-card-dark p-5 rounded">
                    <form
                            x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            class="l-custom" wire:submit.prevent='store'
                        >


                        @csrf
                        <div class="mb-2">
                            <label for="Fname" class="form-label float-end">@lang('validation.attributes.full_name')</label>
                            <input wire:model.defer='form.full_name' type="text"  class="form-control form-control-3  @error('form.full_name') is-invalid @enderror" />
                            @error('form.full_name') <p class="text-danger">{{$message}}</p> @enderror
                        </div>

                        <div class="mb-2">
                            <label for="Fname" class="form-label float-end">@lang('validation.attributes.course_ids')</label>
                            <select wire:model.defer='form.course_ids' multiple class="form-control">
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" data-search='{{ $course->{'title_'.app()->getLocale()} }}'>{{ $course->{'title_'.app()->getLocale()} }}</option>
                                @endforeach
                            </select>
                            @error('form.course_ids') <p class="text-danger">{{$message}}</p> @enderror
                        </div>


                        <div class="mb-2">
                            <label for="Fname" class="form-label float-end">@lang('validation.attributes.national_id')</label>
                            <input wire:model.defer='form.national_id' type="text"  class="form-control form-control-3  @error('form.national_id') is-invalid @enderror" />
                            @error('form.national_id') <p class="text-danger">{{$message}}</p> @enderror
                        </div>


                        <div wire:loading wire:target="personal_pic">@lang('site.uploading') ...</div>
                        <div wire:loading wire:target="ack_video">@lang('site.uploading') ...</div>
                            <div x-show="isUploading">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div>

                        <div class="mb-2">
                            <label for="Fname" class="form-label float-end">@lang('validation.attributes.personal_pic')</label>
                            <input wire:model='personal_pic' type="file"  class="form-control form-control-3  @error('personal_pic') is-invalid @enderror" />
                            @error('personal_pic') <p class="text-danger">{{$message}}</p> @enderror
                        </div>

                        <div class="mb-2">
                            <label for="Fname" class="form-label float-end">@lang('validation.attributes.ack_video')</label>
                            <input wire:model='ack_video' type="file"  class="form-control form-control-3  @error('ack_video') is-invalid @enderror" />
                            @error('ack_video') <p class="text-danger">{{$message}}</p> @enderror
                        </div>


                        <div class="d-grid gap-2">
                            <button type="submit" x-show="!isUploading" class="btn px-3 mt-2 btn-danger">@lang('site.register')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
