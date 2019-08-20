<form class="form-inline mb-3" id="MyForm">
    <div class="form-group ">
        <label for="dateFromPicker">From: </label>
        <div class="input-group date " id="dateFromPicker" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" id="dateFrom" data-target="#dateFromPicker"/>
            <div class="input-group-append" data-target="#dateFromPicker" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="dateFromPicker">To: </label>
        <div class="input-group date" id="dateToPicker" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" id="dateTo" data-target="#dateToPicker"/>
            <div class="input-group-append" data-target="#dateToPicker" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>

    <div class="form-group ml-2">
        <button type="submit" class="btn btn-primary ml-2">Submit</button>
    </div>
</form>
<hr>
