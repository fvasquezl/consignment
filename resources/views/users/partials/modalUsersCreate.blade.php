<div class="modal fade" id="modalUsersCreate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <form id="usersForm" name="usersForm">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   placeholder="Name">
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>

                        <div class="form-group ">
                            <label for="email">Email:</label>
                            <input type="email"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   placeholder="Email">
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>

                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select class="form-control" name="role" id="role">
                                <option value="">-- Role --</option>
                                    <option value="mi">MI User</option>
                                    <option value="sohnen">Sohnen User</option>
                            </select>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>

                        <div class="form-group mt-2">
                            <label for="password">Password:</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="Password">
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
