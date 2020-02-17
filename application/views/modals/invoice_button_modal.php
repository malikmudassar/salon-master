<div id="invoiceButton" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="invoiceButton" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#calendar').fullCalendar('refetchEvents'); $('#invoiceButton').modal('hide');" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" align="center">
                <h4>
                    You cannot add services in a different date for a client who is currently being serviced - Please invoice the current visit to create a new appointment!
                </h4>
                <?php echo form_open('open_new_invoice', 'target="_blank"');?>
                <!--<form action="open_new_invoice" method="post" target="_blank">-->
                    <input type="hidden" class="form-control" id="invoice_button_visit_id" name="visit-id">
                    <button type="submit" style="" class="btn btn-pink btn-sm waves-effect waves-light">Generate Invoice</button>
                </form>
            </div>
        </div>
    </div>
</div>