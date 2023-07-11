$(document).ready(function () {
    $(".delete").click(function () {
        if (!confirm("Do you want to delete?")) {
            return false;
        }
    });

    $(".approve").click(function () {
        if (!confirm("Are you sure to approve / accept?")) {
            return false;
        }
    });
});

$(document).ready(function () {
    $("#dataTable").DataTable({
        stateSave: true,
    });
});

let userId = "{{ auth()->user()->id }}";
Echo.private(`Modules.Admin.Entities.User.${userId}`)
    .notification((notification) => {
        console.log(notification.type);

        let totalNotification = $("#notificationCount").text();
        $("#notificationCount").text(parseInt(totalNotification) + 1);

        $("#notification-list-popup").prepend(`
        <li>
            <a href="{{ route('support-tickets.index') }}/${notification.supportTicketId}" style="font-size: 12px; padding: 0" class="text-left p-0 d-block">
                ${notification.message} <br>
            
                <small>
                    Recent
                </small>
            </a>
        </li>

        `);

        $("#no-notification").hide();

        Toastify({
            text: notification.message,
            className: "info",
            style: {
                background: "linear-gradient(to right, #5bffe9, #007af5)",
                fontSize: "16px",
                boxShadow: "2px 2px 2px #000",
            },
            close: true,
        }).showToast();
    })
    .error((error) => {
        console.error(error);
    });
window.onload = function () {
    const activeMenuItem = document.querySelector(".active");
    if (activeMenuItem) {
        activeMenuItem.scrollIntoView({
            behavior: "smooth",
        });
    }
};

$(".form-item input").on("keyup change", function () {
    if ($(this).val().trim() !== "") {
        $(this).attr("value", $(this).val());
    } else {
        $(this).attr("value", $(this).val());
    }
});

$(document).on("change", ".form-item input", function () {
    if ($(this).val().trim() !== "") {
        $(this).attr("value", $(this).val());
    } else {
        $(this).attr("value", $(this).val());
    }
});

/**
 * Calculate total amount
 *
 * @param {string} tableSelector
 * @param {string} quantitySelector
 * @param {string} rateSelector
 * @param {string} totalAmountSelector
 */
function calculateTotal(
    tableSelector,
    quantitySelector,
    rateSelector,
    totalAmountSelector
) {
    $(tableSelector).on(
        "keyup",
        quantitySelector + "," + rateSelector,
        function () {
            let quantity = $(this).closest("tr").find(quantitySelector).val();
            let rate = $(this).closest("tr").find(rateSelector).val();
            let total = quantity * rate;
            $(this).closest("tr").find(totalAmountSelector).val(total);
        }
    );
}
