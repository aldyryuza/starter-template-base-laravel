<!-- Modal -->
<div class="modal fade" id="data-modal-karyawan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="data-modal-karyawanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Data Employee
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-12 table-responsive">
                        <table id="data-table-employee" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ACTION</th>
                                    <th>NO</th>
                                    <th>EMPLOYEE CODE</th>
                                    <th>NAME</th>
                                    <th>JOB TITLE</th>
                                    <th>SUBSIDIARY</th>
                                    <th>DEPARTMENT</th>
                                    <th>CONTACT</th>
                                    <th>EMAIL</th>
                                    <th>ADDRESS</th>
                                    <th>CREATED AT</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
