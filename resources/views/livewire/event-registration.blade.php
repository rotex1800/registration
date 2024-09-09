@php use App\Models\ClothesSize; @endphp
@php  @endphp
<div>
    <div class="text-4xl"> {{ $this->event->name }}</div>
    <div class="flex flex-row">
        <div>
            <div class="my-1 flex flex-row text-2xl">
                <div class="mr-2">Von:</div>
                <div>{{ $this->event->start->translatedFormat('d. F Y') }}</div>
            </div>
            <div class="my-1 flex flex-row text-2xl">
                <div class="mr-2">Bis:</div>
                <div>{{ $this->event->end->translatedFormat('d. F Y') }}</div>
            </div>
        </div>
    </div>
    <div class="text-white my-4">
        @if(!$this->hasUserRegistered())
            <button class="bg-blue-800 p-3 rounded" wire:click="register">{{ __('registration.apply') }}</button>
        @endif
    </div>
    @if($this->hasUserRegistered())

        <button
            class="{{ $this->isPartOneActive()
                        ? "bg-blue-500 font-bold text-white"
                        : 'border-blue-400 bg-blue-300' }}
                        mr-4 py-2 px-4 border-2 rounded-full hover:bg-blue-400"
            wire:click="showPartOne" active>{{ __('registration.part_one') }}</button>

        <button class="{{ $this->isPartTwoActive()
                        ? "bg-blue-500 font-bold text-white"
                        : 'border-blue-400 bg-blue-300' }}
                        mr-4 py-2 px-4 border-2 rounded-full hover:bg-blue-400"
                wire:click="showPartTwo">{{ __('registration.part_two') }}</button>

        {{-- Part One --}}
        @if($this->isPartOneActive())

            <p class="mt-8">{{__('registration.explanation')}}</p>
            <h2 class="text-2xl mt-8">{{  __('registration.about-you') }} {{ $user->isComplete() ? '✅' : '' }}</h2>
            <div class="mt-4 grid grid-cols-input gap-4 items-center">
                <div><label for="firstname">{{ __('registration.first_name') }}</label></div>
                <input class="rounded" type="text" id="firstname" wire:model.live.debounce.500ms="user.first_name">

                <div><label for="family-name">{{ __('registration.family_name') }}</label></div>
                <input class="rounded" type="text" id="family-name" wire:model.live.debounce.500ms="user.family_name">

                <div>
                    <label for="birthday">{{ __('registration.birthday') }}</label>
                    @error('user.birthday')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input class="rounded" type="date" id="birthday" wire:model.live.debounce.500ms="user.birthday">

                <label for="gender">{{ __('registration.gender.gender') }}</label>
                <select class="rounded" id="gender" wire:model.live.debounce.500ms="user.gender">
                    <option value="female">{{ __('registration.gender.female') }}</option>
                    <option value="male">{{ __('registration.gender.male') }}</option>
                    <option value="diverse">{{ __('registration.gender.diverse') }}</option>
                    <option value="na">{{ __('registration.gender.na') }}</option>
                </select>

                <div>
                    <label for="mobile_phone">{{ __('registration.mobile_phone') }}</label>
                    @error('user.mobile_phone')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror

                </div>
                <input type="tel" id="mobile_phone" class="rounded" wire:model.live.debounce.500ms="user.mobile_phone">

                <div><label for="tshirt-size">{{ __('registration.tshirt-size') }}</label></div>
                <select class="rounded" id="tshirt-size" wire:model.live="additionalInfo.tshirt_size">
                    @foreach(ClothesSize::cases() as $size)
                        <option value="{{ $size->value }}">{{ $size->displayName() }}</option>
                    @endforeach
                </select>

                <div><label for="allergies">{{ __('registration.allergies') }}</label></div>
                <input class="rounded" type="text" id="allergies" wire:model.live.debounce.500ms="additionalInfo.allergies">

                <div><label for="diet">{{ __('registration.diet') }}</label></div>
                <input class="rounded" type="text" id="diet" wire:model.live.debounce.500ms="additionalInfo.diet">

                <div><label for="desired_group">{{ __('registration.desired_group') }}</label></div>
                <input class="rounded" type="text" id="desired_group" wire:model.live.debounce.500ms="additionalInfo.desired_group">

                <label for="health-issues">{{ __('registration.health_issues') }}</label>
                <textarea class="rounded min-h-40" id="health-issues"
                          wire:model.live.debounce.500ms="user.health_issues"></textarea>
            </div>

            <h2 class="text-2xl mt-8">{{  __('registration.passport') }} {{ $passport->isComplete() ? '✅' : '' }}</h2>
            <p>{{ __('registration.passport-explanation') }}</p>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">
                <div><label for="nationality">{{ __('registration.nationality') }}</label></div>
                <input id="nationality" type="text" class="rounded" wire:model="passport.nationality">

                <div><label for="passport-number">{{ __('registration.passport-number') }}</label></div>
                <input type="text" id="passport-number" class="rounded"
                       wire:model.live.debounce.500ms="passport.passport_number">

                <div><label for="passport-issue-date">{{ __('registration.passport-issue-date') }}</label>
                    @error('passport.issue_date')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <input type="date" id="passport-issue-date" class="rounded"
                       wire:model.live.debounce.500ms="passport.issue_date">

                <div>
                    <label for="passport-expiration-date">{{ __('registration.passport-expiration-date') }}</label>
                    @error('passport.expiration_date')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input id="passport-expiration-date" type="date" class="rounded"
                       wire:model.live.debounce.500ms="passport.expiration_date">

            </div>

            <h2 class="text-2xl mt-8">{{  __('registration.about-rotary') }} {{ $rotary->isComplete() ? '✅' : '' }}</h2>
            <p>{{__('registration.rotary-explanation')}}</p>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">

                <div><label for="host-club">{{ __('registration.rotary.host-club') }}</label></div>
                <input id="host-club" class="rounded" type="text" wire:model.live.debounce.500ms="rotary.host_club">

                <div><label for="host-district">{{ __('registration.rotary.host-district') }}</label></div>
                <input id="host-district" type="text" class="rounded" wire:model.live.debounce.500ms="rotary.host_district">

                <div><label for="sponsor-club">{{ __('registration.rotary.sponsor-club') }}</label></div>
                <input id="sponsor-club" type="text" class="rounded" wire:model.live.debounce.500ms="rotary.sponsor_club">

                <div><label for="sponsor-district">{{ __('registration.rotary.sponsor-district') }}</label></div>
                <select class="rounded" id="sponsor-district" wire:model.live.debounce.500ms="rotary.sponsor_district">
                    @foreach($this->districts as $district)
                        <option value="{{$district}}">{{$district}}</option>
                    @endforeach
                </select>
            </div>

            <h2 class="text-2xl mt-8">
                {{  __('registration.about-counselor') }} {{ $counselor->isComplete() ? '✅' : '' }}
            </h2>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">

                <div><label for="counselor-name">{{ __('registration.counselor.name') }}</label></div>
                <input id="counselor-name" class="rounded" type="text" wire:model.live.debounce.500ms="counselor.name">

                <div><label for="counselor-telephone">{{ __('registration.counselor.telephone') }}</label></div>
                <input id="counselor-telephone" type="tel" class="rounded" wire:model.live.debounce.500ms="counselor.phone">
                @error('counselor.phone')
                <div class="text-red-500">{{ $message }}</div>
                @enderror

                <div>
                    <label for="counselor-email">{{ __('registration.counselor.email') }}</label>
                    @error('counselor.email')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input id="counselor-email" type="email" class="rounded" wire:model.live.debounce.500ms="counselor.email">

            </div>

            <h2 class="text-2xl mt-8">{{  __('registration.about-yeo') }} {{ $yeo->isComplete() ? '✅' : '' }}</h2>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">

                <div><label for="yeo-name">{{ __('registration.yeo.name') }}</label></div>
                <input id="yeo-name" class="rounded" type="text" wire:model.live.debounce.500ms="yeo.name">

                <div><label for="yeo-telephone">{{ __('registration.yeo.telephone') }}</label></div>
                <input id="yeo-telephone" type="tel" class="rounded" wire:model.live.debounce.500ms="yeo.phone">
                @error('yeo.phone')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
                <div>
                    <label for="yeo-email">{{ __('registration.yeo.email') }}</label>
                    @error('yeo.email')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input id="yeo-email" name="Yeo E-Mail" type="email" class="rounded"
                       wire:model.live.debounce.500ms="yeo.email">
            </div>

            <h2 class="text-2xl mt-8">
                {{  __('registration.about-bio-family') }} {{ $bioFamily->isComplete() ? '✅' : '' }}
            </h2>
            <p>{{__('registration.bio-family-explanation')}}</p>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">

                <div>
                    <label for="bio-mother">{{ __('registration.bio-family.parent-one') }}</label>
                </div>
                <input type="text" id="bio-mother" class="rounded block"
                       wire:model.live.debounce.500ms="bioFamily.parent_one">

                <div><label for="bio-father">{{ __('registration.bio-family.parent-two') }}</label></div>
                <input type="text" id="bio-father" class="rounded" wire:model.live.debounce.500ms="bioFamily.parent_two">

                <div><label for="bio-email">{{ __('registration.bio-family.email') }}</label>
                    @error('bioFamily.email')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input type="email" id="bio-email" class="rounded" wire:model.live.debounce.500ms="bioFamily.email">

                <div><label for="bio-telephone">{{ __('registration.bio-family.telephone') }}</label></div>
                <input type="tel" id="bio-telephone" class="rounded" wire:model.live.debounce.500ms="bioFamily.phone">
                @error('bioFamily.phone')
                <div class="text-red-500">{{ $message }}</div>
                @enderror

            </div>

            <h2 class="text-2xl mt-8">
                {{  __('registration.about-host-family-one') }} {{ $hostFamilyOne->isComplete() ? '✅' : '' }}
            </h2>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">

                <div><label for="host-name-one">{{ __('registration.host-family.name') }}</label></div>
                <input type="text" id="host-name-one" class="rounded" wire:model.live.debounce.500ms="hostFamilyOne.name">

                <div>
                    <label for="host-email-one">{{ __('registration.host-family.email') }}</label>
                    @error('hostFamilyOne.email')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <input type="text" id="host-email-one" class="rounded" wire:model.live.debounce.500ms="hostFamilyOne.email">

                <div><label for="host-phone-one">{{ __('registration.host-family.phone') }}</label>
                    @error('hostFamilyOne.phone')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input type="text" id="host-phone-one" class="rounded" wire:model.live.debounce.500ms="hostFamilyOne.phone">

                <div><label for="host-address-one">{{ __('registration.host-family.address') }}</label></div>
                <input type="text" id="host-address-one" class="rounded"
                       wire:model.live.debounce.500ms="hostFamilyOne.address">

            </div>

            <h2 class="text-2xl mt-8">
                {{  __('registration.about-host-family-two') }} {{ $hostFamilyTwo->isComplete() ? '✅' : '' }}
            </h2>
            <p>{{__('registration.nth-host-family-explanation')}}</p>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">

                <div><label for="host-name-two">{{ __('registration.host-family.name') }}</label></div>
                <input type="text" id="host-name-two" class="rounded" wire:model.live.debounce.500ms="hostFamilyTwo.name">

                <div>
                    <label for="host-email-two">{{ __('registration.host-family.email') }}</label>
                    @error('hostFamilyTwo.email')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input type="text" id="host-email-two" class="rounded" wire:model.live.debounce.500ms="hostFamilyTwo.email">

                <div><label for="host-phone-two">{{ __('registration.host-family.phone') }}</label>
                    @error('hostFamilyTwo.phone')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input type="text" id="host-phone-two" class="rounded" wire:model.live.debounce.500ms="hostFamilyTwo.phone">

                <div><label for="host-address-two">{{ __('registration.host-family.address') }}</label></div>
                <input type="text" id="host-address-two" class="rounded"
                       wire:model.live.debounce.500ms="hostFamilyTwo.address">

            </div>

            <h2 class="text-2xl mt-8">
                {{  __('registration.about-host-family-three') }} {{ $hostFamilyThree->isComplete() ? '✅' : '' }}
            </h2>
            <p>{{__('registration.nth-host-family-explanation')}}</p>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">

                <div>
                    <label for="host-name-three">{{ __('registration.host-family.name') }}</label>
                </div>
                <input type="text" id="host-name-three" class="rounded"
                       wire:model.live.debounce.500ms="hostFamilyThree.name">

                <div>
                    <label for="host-email-three">{{ __('registration.host-family.email') }}</label>
                    @error('hostFamilyThree.email')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input type="text" id="host-email-three" class="rounded"
                       wire:model.live.debounce.500ms="hostFamilyThree.email">

                <div><label for="host-phone-three">{{ __('registration.host-family.phone') }}</label>
                    @error('hostFamilyThree.phone')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <input type="text" id="host-phone-three" class="rounded"
                       wire:model.live.debounce.500ms="hostFamilyThree.phone">

                <div><label for="host-address-three">{{ __('registration.host-family.address') }}</label></div>
                <input type="text" id="host-address-three" class="rounded"
                       wire:model.live.debounce.500ms="hostFamilyThree.address">

            </div>

            <h2 class="text-2xl mt-8">
                {{  __('registration.comment') }} {{ $comment->isComplete() ? '✅' : '' }}
            </h2>
            <p>{{__('registration.comment-explanation')}}</p>
            <div class="grid mt-4 grid-cols-input gap-4 items-center">
                <label for="comment">{{ __('registration.comment') }}</label>
                <textarea class="rounded min-h-40" id="comment"
                          wire:model="comment.body">{{ $comment->body }}</textarea>

            </div>

        @endif

        {{-- Part Two --}}
        @if($this->isPartTwoActive())
            <livewire:document-upload :display-name="__('registration.rules')"
                                      :category="App\Models\DocumentCategory::Rules->value"
                                      wire:key="{{ App\Models\DocumentCategory::Rules->value }}"
            />

            <livewire:document-upload :display-name="__('registration.appf-copy')"
                                      :category="App\Models\DocumentCategory::AppfCopy->value"
                                      wire:key="{{ App\Models\DocumentCategory::AppfCopy->value }}"
            />

            <livewire:document-upload :display-name="__('registration.insurance-policy')"
                                      :category="App\Models\DocumentCategory::InsurancePolice->value"
                                      wire:key="{{ App\Models\DocumentCategory::InsurancePolice->value }}"
            />

            <livewire:document-upload :display-name="__('registration.passport-copy')"
                                      :category="App\Models\DocumentCategory::PassportCopy->value"
                                      wire:key="{{ App\Models\DocumentCategory::PassportCopy->value }}"
            />

            <livewire:document-upload :display-name="__('registration.residence-permit')"
                                      :category="App\Models\DocumentCategory::ResidencePermit->value"
                                      wire:key="{{ App\Models\DocumentCategory::ResidencePermit->value }}"
            />

            <livewire:document-upload :display-name="__('registration.school-certificate')"
                                      :category="App\Models\DocumentCategory::SchoolCertificate->value"
                                      wire:key="{{ App\Models\DocumentCategory::SchoolCertificate->value }}"
            />

            <livewire:document-upload :display-name="__('registration.picture')"
                                      :category="App\Models\DocumentCategory::Picture->value"
                                      wire:key="{{ App\Models\DocumentCategory::Picture->value }}"
            />

            <livewire:document-upload :display-name="__('registration.motivation')"
                                      :category="App\Models\DocumentCategory::Motivation->value"
                                      wire:key="{{ App\Models\DocumentCategory::Motivation->value }}"
            />
        @endif

        <button class="bg-red-500 p-3 rounded mt-5 text-white font-bold"
                wire:click="unregister">{{ __('registration.dont-participate') }}</button>
    @endif
</div>
