$(function () {
    "use strict";

    $(".preloader").fadeOut();

    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on("click", function () {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
    });

    // ==============================================================
    // Right sidebar options
    // ==============================================================
    $(function () {
        $(".service-panel-toggle").on("click", function () {
            $(".customizer").toggleClass("show-service-panel");
        });
        $(".page-wrapper").on("click", function () {
            $(".customizer").removeClass("show-service-panel");
        });
    });

    // ==============================================================
    //tooltip
    // ==============================================================
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    // ==============================================================
    //Popover
    // ==============================================================
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    // ==============================================================
    // Perfact scrollbar
    // ==============================================================
    $(
        ".message-center, .customizer-body, .scrollable, .scroll-sidebar"
    ).perfectScrollbar({
        wheelPropagation: !0,
    });

    // ==============================================================
    // Resize all elements
    // ==============================================================
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();
    // ==============================================================
    // To do list
    // ==============================================================
    $(".list-task li label").click(function () {
        $(this).toggleClass("task-done");
    });

    // ==============================================================
    // This is for the innerleft sidebar
    // ==============================================================
    $(".show-left-part").on("click", function () {
        $(".left-part").toggleClass("show-panel");
        $(".show-left-part").toggleClass("ti-menu");
    });

    // For Custom File Input
    $(".custom-file-input").on("change", function () {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next(".custom-file-label").html(fileName);
    });
});

function timeAgo(timestamp) {
    const now = new Date();
    const timeDiff = now - new Date(timestamp);

    const intervals = [
        { label: "tahun", value: 1000 * 60 * 60 * 24 * 365 },
        { label: "bulan", value: 1000 * 60 * 60 * 24 * 30 },
        { label: "minggu", value: 1000 * 60 * 60 * 24 * 7 },
        { label: "hari", value: 1000 * 60 * 60 * 24 },
        { label: "jam", value: 1000 * 60 * 60 },
        { label: "menit", value: 1000 * 60 },
        { label: "detik", value: 1000 },
    ];

    for (const interval of intervals) {
        const count = Math.floor(timeDiff / interval.value);
        if (count >= 1) {
            return `${count} ${interval.label} yang lalu`;
        }
    }

    return "Baru saja";
}

$(document).ready(function () {
    $.get("/notifications", (data) => {
        if (data.count > 0) {
            $(".notify-no").html(data.count);
        }

        if (data.notifications.length > 0) {
            $.each(data.notifications, (i, e) => {
                $(".notifications").append(
                    `<a
            href="${e.link}?notif=${e.id}"
            class="message-item ${
                e.is_read == "0" && "bg-light"
            } d-flex align-items-center border-bottom px-3 py-2"
            >
            <div class="btn btn-${e.color} rounded-circle btn-circle d-flex">
                <i class="fas ${e.icon} m-auto"></i>
            </div>
            <div class="w-75 d-inline-block v-middle pl-2">
                <h6 class="message-title mb-0 mt-1">${e.title}</h6>
                <span class="font-12 text-nowrap d-block text-muted"
                >${e.description}</span
                >
                <span class="font-12 text-nowrap d-block text-muted"
                >${timeAgo(e.created_at)}</span
                >
            </div>
            </a>`
                );
            });
        } else {
            $(".notifications").append(
                `<div class="message-item border-bottom px-2 py-3">
        Tidak ada notifikasi
        </div>`
            );
        }
    });
});

$("#bell").on("click", function () {
    $(".notify-no", this).empty();
});

function formatDate(dateString) {
    const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    const dateParts = dateString.split("-");
    const year = dateParts[0];
    const month = parseInt(dateParts[1], 10);
    const day = parseInt(dateParts[2], 10);

    return `${day} ${months[month - 1]} ${year}`;
}
