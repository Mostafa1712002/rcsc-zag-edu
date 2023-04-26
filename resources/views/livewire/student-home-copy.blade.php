<section x-data class="sign-in" style='min-height:500px;'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">

                @if($has_already_answered_exam)
                <div class="alert alert-warning">@lang('site.you_have_already_answered_this_exam')</div>
                @else
                <p class="sign-head"><i class="fas fa-arrow-right"></i>@lang('site.your_pic_during_exam')</p>
                <div class="sign-card bg-card-dark p-5 rounded">
                    @if($has_uploaded_exam_pic)
                    <img src="{{auth('student')->user()->exam_pic_url}}" style='max-width:50%' alt="" />
                    <p>*@lang('site.you_can_change_your_pic')</p>
                    @endif
                    <form x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="l-custom" wire:submit.prevent='store'>
                        <div wire:loading wire:target="exam_pic">@lang('site.uploading') ...</div>
                        <div x-show="isUploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>

                        @csrf


                        <div class="mb-2">
                            <label for="Fname" class="form-label float-end">@lang('validation.attributes.exam_pic')</label>
                            <input wire:model='exam_pic' type="file" class="form-control form-control-3  @error('exam_pic') is-invalid @enderror" />
                            @error('exam_pic') <p class="text-danger">{{$message}}</p> @enderror
                        </div>


                        <div class="d-grid gap-2">
                            <button type="submit" x-show="!isUploading" class="btn btn-2 px-3 mt-2">@if($has_uploaded_exam_pic) @lang('site.upload_new_exam_pic') @else @lang('site.upload_and_proceed') @endif</button>
                        </div>
                    </form>

                </div><!-- Register card-->



                <hr>
                <p class="sign-head"><i class="fas fa-arrow-right"></i>@lang('site.questions')</p>
                @if($this->has_uploaded_exam_pic)
                @foreach($questions as $question)
                <div class="sign-card bg-card-dark p-5 rounded @if($loop->index>$visible_questions) d-none @endif" style='margin-bottom:10px;'>
                    <p style='text-align:right'>{{$question->content}}</p>
                    <table class='table' dir='rtl'>
                        @foreach($question->answers as $answer)
                        <tr>
                            <td style='width:10%'>
                                <input wire:model='student_answers.{{$question->id}}' value='{{$answer->id}}' type="radio" x-on:click="$wire.setAnswer({{$question->id}},{{$answer->id}})">

                            </td>
                            <td style='text-align:right;width:90%'>
                                {{$answer->content}}
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
                @endforeach

                <div class="d-grid gap-2">
                    @if($error_message)
                    <p class="text-danger">{{$error_message}}</p>
                    @endif
                    <button x-on:click='$wire.saveAnswers()' type="button" class="@if($visible_questions<count($questions)) d-none @endif btn btn-2 px-3 mt-2 @if($error_message) disabled @endif">@lang('site.save_answers')</button>
                </div>

                @else
                <div class="alert alert-warning">@lang('site.please_upload_exam_pic')</div>
                @endif
                @endif
            </div>
        </div>
    </div>
</section>
{{-- style --}}
@push('styles')
<style>
    .sign-card {
        background: #B0DAFF;
        box-shadow: 0px 0px 10px #00000029;
    }

    .sign-card label {
        font-size: 16px;
        font-weight: 500;
        color: #212529;
        margin-bottom: 10px;
    }

    .sign-head {
        font-size: 20px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 20px;
    }

    .sign-card .form-control {
        background: #B0DAFF;
        border-radius: 10px;
        border: none;
        padding: 15px;
        font-size: 16px;
        font-weight: 500;
        color: #000;
        margin-bottom: 20px;
    }

    .sign-card .form-control:focus {
        background: #F2F2F2;
        border-radius: 10px;
        border: none;
        padding: 15px;
        font-size: 16px;
        font-weight: 500;
        color: #000;
        margin-bottom: 20px;
    }

    .sign-card .form-control::placeholder {
        color: #000;
        font-size: 16px;
        font-weight: 500;
    }

    .sign-card .form-control:focus::placeholder {
        color: #000;
        font-size: 16px;
        font-weight: 500;
    }

    .table {
        background-color: #B0DAFF
    }



</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        var anchorWidth = $('td a').outerWidth(); // Get the width of the anchor element
        $('td').css('width', anchorWidth + 'px'); // Set the width of the td element to match
    });

</script>
@endpush
