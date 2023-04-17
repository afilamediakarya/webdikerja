var Panel = (function () {
    // Private properties
    var _element;
    var _offcanvasObject;

    // Private functions
    var _init = function () {
        var header = KTUtil.find(_element, ".offcanvas-header");
        var content = KTUtil.find(_element, ".offcanvas-content");

        _offcanvasObject = new KTOffcanvas(_element, {
            overlay: true,
            baseClass: "offcanvas",
            placement: "right",
            closeBy: "side_form_close",
            toggleBy: "",
        });

        KTUtil.scrollInit(content, {
            disableForMobile: true,
            resetHeightOnDestroy: true,
            handleWindowResize: true,
            height: function () {
                var height = parseInt(KTUtil.getViewPort().height);

                if (header) {
                    height = height - parseInt(KTUtil.actualHeight(header));
                    height = height - parseInt(KTUtil.css(header, "marginTop"));
                    height =
                        height - parseInt(KTUtil.css(header, "marginBottom"));
                }

                if (content) {
                    height =
                        height - parseInt(KTUtil.css(content, "marginTop"));
                    height =
                        height - parseInt(KTUtil.css(content, "marginBottom"));
                }

                height = height - parseInt(KTUtil.css(_element, "paddingTop"));
                height =
                    height - parseInt(KTUtil.css(_element, "paddingBottom"));

                height = height - 2;

                return height;
            },
        });
    };

    // Public methods
    return {
        init: function (id) {
            _element = KTUtil.getById(id);

            if (!_element) {
                return;
            }

            // Initialize
            _init();
        },

        action: function (data, type = null) {
            if (data == "show") {
                $("#createForm")[0].reset();
                $("input").removeClass("is-invalid");
                $("select").removeClass("is-invalid");
                $("textarea").removeClass("is-invalid");
                $(".text-danger").html("");
                _offcanvasObject.show();
            } else if (data == "hide") {
                _offcanvasObject.hide();
            }
            $("#createForm").attr("data-type", type);
        },
        reviewAktivitas: function (pegawai, bulan) {
            $.ajax({
                type: "GET",
                url: `/get_data/penilaian/review-aktivitas?pegawai=${pegawai}&bulan=${bulan}`,
                success: function (res) {
                    // console.log(res.data);
                    // let result = [];
                    // $.each(res, function (x, y) {
                    //     const date = new Date(y.tanggal).toLocaleDateString();
                    //     if (!result[date]) {
                    //         result[date] = [];
                    //     }

                    //     result[date].push(y);
                    // });
                    let row = "";
                    let num = 0;
                    let total_waktu = 0;
                    let nilai_persentase_kinerja = 0;
                    const groupedData = res.data.kinerja.reduce((acc, item) => {
                        // console.log(acc);
                        const date = item.tanggal;
                        if (!acc[date]) {
                            acc[date] = [];
                        }
                        acc[date].push(item);
                        return acc;
                    }, {});

                    // console.log(groupedData);

                    $.each(groupedData, function (x, y) {
                        let jumlah_waktu_pertanggal = 0;
                        $.each(y, function (i, v) {
                            const date = new Date(v.created_at);
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(
                                2,
                                "0"
                            );
                            const day = String(date.getDate()).padStart(2, "0");
                            const formattedDate = `${year}-${month}-${day}`;

                            const d1 = new Date(v.tanggal);
                            const d2 = new Date(v.created_at);

                            // Calculate the difference in days between the two dates
                            const diffTime = Math.abs(
                                d2.getTime() - d1.getTime()
                            );
                            const diffDays = Math.ceil(
                                diffTime / (1000 * 60 * 60 * 24)
                            );

                            jumlah_waktu_pertanggal += parseInt(v.waktu);
                            total_waktu += parseInt(v.waktu);

                            num += 1;
                            row += `<tr><td>${num}</td><td>${
                                v.tanggal
                            }</td><td><span class="${
                                diffDays >= 7
                                    ? "text-danger fw-bolder"
                                    : "text-dark"
                            }">${formattedDate}</span></td>
                            <td>${v.nama_aktivitas}</td>
                            <td>${v.hasil}</td>
                            <td> <span class="text-${
                                v.waktu < 0 ? "danger" : "dark"
                            }"> ${v.waktu} </span> </td>
                            <td>
                                <span class="switch switch-sm switch-icon">
								<label>
									<input type="checkbox" ${
                                        v.kesesuaian === "1" ? "checked" : ""
                                    } name="kesesuaian" class="update_kesesuaian" data-index="${
                                v.id
                            }">
                                        <span></span>
                                    </label>
                                </span>
                            </td>
                            <td><button type="button" class="btn btn-primary btn-icon btn-sm" id="ubah_review_aktivitas" data-index="${
                                v.id
                            }"> <span class="edit-icon-custom"></span> </button><button type="button" class="btn btn-danger btn-icon btn-sm ml-2" id="hapus_aktivitas" data-id="${
                                v.id
                            }">  <span class="trash-icon-custom"></span> </button></td>
                            <tr>`;
                        });
                        row += `<tr>
                            <td colspan="5" style="text-align: right;">Total waktu </td>
                            <td> <span class="badge badge-${
                                jumlah_waktu_pertanggal > 420
                                    ? "danger"
                                    : "secondary"
                            }">${jumlah_waktu_pertanggal}</span> </td>
                            <td colspan="2"></td>
                        </tr>`;
                    });

                    if (total_waktu > 0 || res.data.waktu > 0) {
                        nilai_persentase_kinerja =
                            (total_waktu / res.data.waktu) * 100;
                    }

                    if (nilai_persentase_kinerja > 100) {
                        nilai_persentase_kinerja = 100;
                    }

                    //   $nilai_produktivitas_kerja = 0;

                    //   if (
                    //       $capaian_prod_kinerja > 0 ||
                    //       $target_produktivitas_kerja > 0
                    //   ) {
                    //       $nilai_produktivitas_kerja =
                    //           ($capaian_prod_kinerja /
                    //               $target_produktivitas_kerja) *
                    //           100;
                    //   }

                    //   if ($nilai_produktivitas_kerja > 100) {
                    //       $nilai_produktivitas_kerja = 100;
                    //   }

                    row += `<tr>
                            <td colspan="5">Target waktu</td>
                            <td> <span class="badge badge-primary">${total_waktu}</span> </td>
                            <td colspan="2"></td>
                        </tr>`;

                    row += `<tr>
                            <td colspan="5">Total target waktu </td>
                            <td> <span class="badge badge-primary">${res.data.waktu}</span> </td>
                            <td colspan="2"></td>
                        </tr>`;

                    row += `<tr>
                        <td colspan="5">Persentase kinerja </td>
                        <td> <span class="badge badge-primary">${nilai_persentase_kinerja.toFixed(
                            1
                        )} %</span> </td>
                        <td colspan="2"></td>
                    </tr>`;

                    $("#kt_tb_review tbody").html(row);
                },
                error: function (xhr) {
                    alert("gagal");
                },
            });
        },
        getElement: function () {
            return _element;
        },
    };
})();
