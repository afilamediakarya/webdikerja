var AxiosCall = function() {
    return {
        post: function(_url, _data, _element) {
            console.log(_data);
            axios.post( _url, _data)
            .then(function(res){
                var data = res.data;
                if(data.fail){
                    swal.fire({
                        text: "Maaf Terjadi Kesalahan",
                        title:"Error",
                        timer: 2000,
                        icon: "danger",
                        showConfirmButton:false,
                    });
                }else if(data.invalid){
                    $.each(data.invalid, function( key, value ) {
                        console.log(key);
                        $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                        $("textarea[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                    });
                }else if(data.success){
                    swal.fire({
                        text: "Data anda berhasil disimpan",
                        title:"Sukses",
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        // dataRow.destroy();
                        // dataRow.init();
                        // $(_element)[0].reset();
                        // console.log("ok");
                        // console.log(_data['id_satua_kerja']);
                        // console.log(data['data']['data']['id_satuan_kerja']);
                        datatable_(data['data']['data']['id_satuan_kerja']);
                        $("#createForm")[0].reset();
                        $(_element)[0].reset();
                        $("#table").toggle();
                        $("#form").toggle();
                        Panel.action('hide');
                    });
                }
            }).catch(function(){
                swal.fire({
                    text: "Terjadi Kesalahan Sistem",
                    title:"Error",
                    icon: "error",
                    showConfirmButton:true,
                    confirmButtonText: "OK",
                })
            });
        },
    
        show : function (_url) {
            axios.get(_url)
            .then(function(res){
                var data = res.data;
                console.log(data.success);
                if(data.success){
                    var res = data.success.data;
                    $.each(res, function( key, value ) {
                        $("input[name='"+key+"']").val(value);
                        $("select[name='"+key+"']").val(value);
                        $("textarea[name='"+key+"']").val(value);
                    });
                    Panel.action('show','update');
                }else{
                    swal.fire({
                        text: "Data tidak ditemukan",
                        title:"Not Found",
                        icon: "error",
                        showConfirmButton:true,
                        confirmButtonText: "OK",
                    });
                }
            }).catch(function(err){
                console.log(err);
            });
        },
        
        delete : function(_url){   
            Swal.fire({
                title: "Perhatian ",
                text: "Yakin ingin meghapus data.?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-light-danger",
                    }
            }).then(function(result) {
                if (result.value) {
                    axios.delete(_url)
                    .then(function(res){
                        var data = res.data;
                        console.log(data);
                        if(data.success){
                            Swal.fire(
                                "Deleted!",
                                "Data terhapus",
                                "success"
                            ).then(function() {
                                datatable_(data['data']['data']['id_satuan_kerja']);
                                $("#createForm")[0].reset();
                                $(_element)[0].reset();
                                $("#table").toggle();
                                $("#form").toggle();
                                Panel.action('hide');
                            });
                        }else{
                            Swal.fire(
                                "Error",
                                "Gagal Menghapus Data",
                                "error"
                            );
                        }
                    })
                    .catch(function(err){
                        swal.fire({
                            text: "Terjadi Kesalahan Sistem",
                            title:"Error",
                            icon: "error",
                            showConfirmButton:true,
                            confirmButtonText: "OK",
                        });
                    });
                }
            });
        },

        add_pendidikan_formal: function(_url, _data, _element) {
            console.log(_data);
            axios.post( _url, _data)
            .then(function(res){
                var data = res.data;
                console.log(data);
                if(data.failed){
                    swal.fire({
                        text: "Maaf Terjadi Kesalahan",
                        title:"Error",
                        timer: 2000,
                        icon: "danger",
                        showConfirmButton:false,
                    });
                }else if(data.invalid){
                    $.each(data.invalid, function( key, value ) {
                        console.log(key);
                        $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                        $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                    });
                }else if(data.success){
                    swal.fire({
                        text: "Data anda berhasil disimpan",
                        title:"Sukses",
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        console.log(_element);
                        dataRow.destroy();
                        dataRow.init();
                        Panel.action('hide');
                        $("#createForm")[0].reset();
                        _element[0].reset();
                        $("#document")[0].reset();
                        $("#table").toggle();
                        $("#createForm").toggle();
                    });
                }
            }).catch(function(res){
                var data = res.data;
                console.log(data);
                swal.fire({
                    text: "Terjadi Kesalahan Sistem",
                    title:"Error",
                    icon: "error",
                    showConfirmButton:true,
                    confirmButtonText: "OK",
                })
            });
        },

        update_pendidikan_formal: function(_url, _data, _element) {
            console.log(_url);
            axios.post( _url, _data)
            .then(function(res){
                var data = res.data;
                console.log(data);
                if(data.failed){
                    swal.fire({
                        text: "Maaf Terjadi Kesalahan",
                        title:"Error",
                        timer: 2000,
                        icon: "danger",
                        showConfirmButton:false,
                    });
                }else if(data.invalid){
                    $.each(data.invalid, function( key, value ) {
                        console.log(key);
                        $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                        $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                    });
                }else if(data.success){
                    swal.fire({
                        text: "Data anda berhasil disimpan",
                        title:"Sukses",
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        dataRow.destroy();
                        dataRow.init();
                        Panel.action('hide');
                        $("#createForm")[0].reset();
                        _element[0].reset();
                        $("#table").toggle();
                        $("#createForm").toggle();
                    });
                }
            }).catch(function(res){
                var data = res.data;
                console.log(data);
                swal.fire({
                    text: "Terjadi Kesalahan Sistem",
                    title:"Error",
                    icon: "error",
                    showConfirmButton:true,
                    confirmButtonText: "OK",
                })
            });
        },
    };
}();