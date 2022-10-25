<div>
    <select>
        @foreach($attendees as $attendee)
            <option value="{{ $attendee->id }}">{!! $attendee->full_name !!}</option>
        @endforeach
    </select>
</div>
