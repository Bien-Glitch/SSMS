<?php include './include/header.php';?>
<style>
@media screen and (max-width: 767px) {
    #add-session-term {
        display: none;
    }
}
</style>
<div id="body" data-action="<?php echo $action; ?>" data-query="DESC" class="container-fluid manage-page mb-5">
    <div class="row">
        <div class="col-md-9 s-border-top s-md-border-top-none s-md-border-right">
            <div class="manage-sessions mb-5 mt-4">
                <div class="p-2 w3-black">Manage Sessions</div>
                <span class="w3-large">Available Sessions</span>
                <div id="resp-mess-session" class="alert alert-info m-0 resp-mess" style="display: none"></div>
                <table class="table table-hover table-striped table-borderless table-sm table-danger session-table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="j-link" id="id">#</th>
                            <th class="j-link" id="session">Session</th>
                            <th class="j-link" id="current_session">Current Session</th>
                            <th><i class="fa fa-pencil mx-1"></i> Edit</th>
                        </tr>
                    </thead>
                    <tbody id="sessions-data" style="display: ">
                        <tr>
                            <td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
                            <td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
                            <td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
                            <td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
                        </tr>
                    </tbody>
                </table>
                <hr />
            </div>

            <div class="manage-terms my-2">
                <div class="p-2 w3-dark-grey">Manage Terms</div>
                <span class="w3-large">Available terms</span>
                <div id="resp-mess-term" class="alert alert-info m-0 resp-mess" style="display: none"></div>
                <table class="table table-hover table-striped table-borderless table-sm table-light term-table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="j-link" id="id">#</th>
                            <th class="j-link" id="term">Term</th>
                            <th class="j-link" id="current_term">Current Term</th>
                            <th><i class="fa fa-pencil mx-1"></i> Edit</th>
                        </tr>
                    </thead>
                    <tbody id="terms-data" style="display: ">
                        <tr>
                            <td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
                            <td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
                            <td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
                            <td><img src="./design/imgs/805.svg" alt="" width="30px"></td>
                        </tr>
                    </tbody>
                </table>
                <hr />
            </div>
        </div>

        <div class="col-md-3 order-first order-md-0">
            <div class="j-link d-md-none p-2 w3-green" id="session-term-toggle">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="far fa-plus-circle"></i> Add Session / Term</span>
                    <i class="w3-text-white caret fa fa-caret-circle-down"></i>
                    <i class="w3-text-white caret fa fa-caret-circle-up" style="display: none"></i>
                </div>
            </div>
            <div id="add-session-term">
                <form action="./include/classes/manage.php" method="post" id="add-session-form">
                    <div class="form-group">
                        <label for="session_inp">Session: </label>
                        <div class="input-group">
                            <i class="p-2 far fa-calendar-alt"></i>
                            <input type="text" name="session" id="session_inp" class="form-control form-control-sm" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="c_session">Current Session ? </label>
                        <div class="input-group">
                            <i class="p-2 far fa-question-circle"></i>
                            <div class="d-flex justify-content-around align-items-center">
                                <span class="mx-2 d-flex align-items-center"><span class="mx-1">Yes</span> <label for="c_session_yes"></label><input type="radio" name="c_session" id="c_session_yes" class="" value="*" required /></span>
                                <span class="mx-2 d-flex align-items-center"><span class="mx-1">No</span> <label for="c_session_no"></label><input type="radio" name="c_session" id="c_session_no" class="" value="-" /></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-sm my-md-0 my-1"><i class="far fa-plus-circle"></i> Add Session</button>
                    </div>
                </form>

                <hr />

                <form action="./include/classes/manage.php" method="post" id="add-term-form">
                    <div class="form-group">
                        <label for="term_inp">Term: </label>
                        <div class="input-group">
                            <i class="p-2 far fa-calendar-day"></i>
                            <input type="text" name="term" id="term_inp" class="form-control form-control-sm" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="c_term">Current Term ? </label>
                        <div class="input-group">
                            <i class="p-2 far fa-question-circle"></i>
                            <div class="d-flex justify-content-around align-items-center">
                                <span class="mx-2 d-flex align-items-center"><span class="mx-1">Yes</span> <label for="c_term_yes"></label><input type="radio" name="c_term" id="c_term_yes" class="" value="*" required /></span>
                                <span class="mx-2 d-flex align-items-center"><span class="mx-1">No</span> <label for="c_term_no"></label><input type="radio" name="c_term" id="c_term_no" class="" value="-" /></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary btn-sm my-md-0 my-1"><i class="far fa-plus-circle"></i> Add Term</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let requested = false,
        session_form_id = '#add-session-form',
        term_form_id = '#add-term-form';

    // Function to automatically position the Footer
    function dynamicFooter() {
        if ($('html').hasScrollBar()) {
            console.log('true');
            $('.footer').css({
                'position': 'relative',
                'z-index': '1500'
            });

        } else {
            console.log('false');
            $('.footer').css({
                'position': 'fixed',
                'bottom': '0',
                'right': '0',
                'left': '0'
            });
        }
    }

    function toggleVisibility() {
        let body_width = $(body).width(),
            session_tag = $('#add-session-term');

        if (body_width > '735') {
            if (session_tag.css('display') === 'none') {
                session_tag.css('display', 'block')
            }
        }

        if (body_width < '735') {
            if ($('.caret')[1].style.display !== 'none') {
                session_tag.css('display', 'block');

            } else if (session_tag.css('display') === 'block') {
                session_tag.css('display', 'none')
            }
        }
    }

    function orderSession() {
        $('.session-table th.j-link').each(function(index, value) {
            $(this).attr('title', 'Click to change order: Ascending or Descending');
            $(this).click(function() {
                let text = $(this).text(),
                    column_name = $(this).attr('id'),
                    query = localStorage.getItem(column_name);

                if (query === 'ASC' || query === '') {
                    query = 'DESC';
                    resp_text = 'Descending'

                } else {
                    query = 'ASC';
                    resp_text = 'Ascending'
                }

                $('#resp-mess-session').html('<small>Order Sessions by ' + text + ': ' + resp_text + '</small>').slideDown(800);
                localStorage.setItem(value.id, query);
                manageSession(column_name, query, 'refresh');
                dynamicFooter()
            });
        });
    }

    function orderTerm() {
        $('.term-table th.j-link').each(function(index, value) {
            $(this).attr('title', 'Click to change order: Ascending or Descending');
            $(this).click(function() {
                let text = $(this).text(),
                    column_name = $(this).attr('id'),
                    query = localStorage.getItem(column_name);

                if (query === 'ASC' || query === '') {
                    query = 'DESC';
                    resp_text = 'Descending'

                } else {
                    query = 'ASC';
                    resp_text = 'Ascending'
                }

                $('#resp-mess-term').html('<small>Order Terms by ' + text + ': ' + resp_text + '</small>').slideDown(800);
                localStorage.setItem(value.id, query);
                manageTerm(column_name, query, 'refresh');
                dynamicFooter()
            });
        });
    }

    function manageSession(c, q, getType) {
        let sessions_body = $('#sessions-data');

        if (requested) {
            return;
        }
        requested = true;

        $.ajax({
            url: './include/classes/manage.php',
            method: 'POST',
            data: {
                action: 'manage-sessions',
                column: c,
                query: q
            },
            dataType: 'json',
            success: function(response) {
                let sessions_info = response.data.sessions.data.info,
                    sessions_infoHTML = '';

                if (response.data.sessions.status === '200') {
                    $.each(sessions_info, function(index, value) {
                        sessions_infoHTML += value;
                    });

                } else {
                    sessions_infoHTML = sessions_info;
                }
                sessions_body.fadeOut(800);
                setTimeout(function() {
                    sessions_body.html(sessions_infoHTML).fadeIn(1000);

                    $('.session-table .edit').each(function() {
                        $(this).click(function(e) {
                            e.preventDefault();
                            let session = $(this).data('session');
                            $('#session_inp').val(session)
                        });
                    });
                    $('.session-table .delete').each(function() {
                        $(this).click(function(e) {
                            e.preventDefault();
                            let session = $(this).data('id');
                            deleteSessionTerm(session, 'delete-session', 'Session');
                        });
                    });
                    dynamicFooter();
                }, 900);

                $('.session-table th.j-link').each(function(index, value) {
                    if (getType === 'fresh') {
                        localStorage.removeItem(value.id)
                    }
                });
            }
        });
        requested = false
    }

    function manageTerm(c, q, getType) {
        let terms_body = $('#terms-data');

        if (requested) {
            return;
        }
        requested = true;

        $.ajax({
            url: './include/classes/manage.php',
            method: 'POST',
            data: {
                action: 'manage-terms',
                column: c,
                query: q
            },
            dataType: 'json',
            success: function(response) {
                let terms_info = response.data.terms.data.info,
                    terms_infoHTML = '';

                if (response.data.terms.status === '200') {
                    $.each(terms_info, function(index, value) {
                        terms_infoHTML += value;
                    });

                } else {
                    terms_infoHTML = terms_info;
                }
                terms_body.fadeOut(800);
                setTimeout(function() {
                    terms_body.html(terms_infoHTML).fadeIn(1000);

                    $('.term-table .edit').each(function() {
                        $(this).click(function(e) {
                            e.preventDefault();
                            let term = $(this).data('term');
                            $('#term_inp').val(term)
                        });
                    });
                    $('.term-table .delete').each(function() {
                        $(this).click(function(e) {
                            e.preventDefault();
                            let term = $(this).data('id');
                            deleteSessionTerm(term, 'delete-term', 'Term');
                        });
                    });
                    dynamicFooter();
                }, 900);

                $('.term-table th.j-link').each(function(index, value) {
                    if (getType === 'fresh') {
                        localStorage.removeItem(value.id)
                    }
                });
            }
        });
        requested = false
    }

    function addSessionTerm(form, action) {
        let form_action = $(form).attr('action');

        $(form).ajaxSubmit({
            url: form_action,
            method: 'POST',
            data: {
                action: action
            },
            dataType: 'json',
            success: function(response) {
                if (action === 'add-session') {
                    alert(response.data.add_session.data.message);
                    manageSession('id', 'ASC', 'fresh');
                }
                if (action === 'add-term') {
                    alert(response.data.add_term.data.message);
                    manageTerm('id', 'ASC', 'fresh');
                }
            }
        });
    }

    function deleteSessionTerm(table_id, action, table) {
        if (confirm('Are you sure you want to delete ' + table + ' with id: ' + table_id + '?\r\nThis action cannot be undone!!!')) {
            $.ajax({
                url: './include/classes/manage.php',
                method: 'POST',
                data: {
                    action: action,
                    table_id: table_id
                },
                dataType: 'json',
                success: function(response) {
                    if (action === 'delete-session') {
                        alert(response.data.delete_session.data.message);
                    }
                    if (action === 'delete-term') {
                        alert(response.data.delete_term.data.message);
                    }
                    dynamicFooter();
                }
            });

        } else {
            alert(table + ' deletion cancelled!!!');
        }
    }

    $('#session-term-toggle').click(function(e) {
        e.preventDefault();
        let session_term_wrapper = $('#add-session-term');
        session_term_wrapper.animate({
            'height': 'toggle',
            'padding-top': 'toggle'
        }, 800);

        $('.caret').animate({
            'height': 'toggle'
        }, 0);
        setTimeout(function() {
            dynamicFooter();
        }, 900);
    });

    $('.resp-mess').each(function() {
        $(this).click(function() {
            $(this).fadeOut(800);
            dynamicFooter();
        });
    });

    $(session_form_id).submit(function(e) {
        e.preventDefault();
        addSessionTerm(session_form_id, 'add-session');
    });

    $(term_form_id).submit(function(e) {
        e.preventDefault();
        addSessionTerm(term_form_id, 'add-term');
    });

    $(window).resize(function() {
        toggleVisibility();
        dynamicFooter();
    });

    manageSession('id', 'ASC', 'fresh');
    manageTerm('id', 'ASC', 'fresh');
    toggleVisibility();
    orderSession();
    orderTerm();
});
</script>
<?php include './include/footer.php';?>