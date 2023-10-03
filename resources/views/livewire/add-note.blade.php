<div>
    <div class="flex flex-row w-full mt-2">
        <br>
        <!--suppress HtmlFormInputWithoutLabel -->
        <textarea type="text"
                  id="note"
                  class="block w-auto grow rounded-lg"
                  placeholder="Notiz"
                  wire:model.live.debounce.500ms="note">{{ $note }}</textarea>
    </div>
</div>
