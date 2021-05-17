jQuery(document).ready(function(e) {

	//Driver profile picture

	jQuery("#image_url_driver_picture_btn").click(function(e) {
		e.preventDefault();
		var r = wp.media({
			title: "Upload Image",
			multiple: !1
		}).open().on("select", function() {
			var e = r.state().get("selection").first(),
				a = e.toJSON().url,
				t = e.toJSON().id;
			console.log(e.toJSON().id), jQuery("#driver_picture_attach_id").val(t), jQuery("#driver_picture").attr("src", a),jQuery("#driver_picture").show()
		})
	})

	//Driver profile Id picture

	jQuery("#image_url_driver_id_picture_btn").click(function(e) {
		e.preventDefault();
		var r = wp.media({
			title: "Upload Image",
			multiple: !1
		}).open().on("select", function() {
			var e = r.state().get("selection").first(),
				a = e.toJSON().url,
				t = e.toJSON().id;
			console.log(e.toJSON().id), jQuery("#driver_id_picture_attach_id").val(t), jQuery("#driver_id_picture").attr("src", a), jQuery("#driver_id_picture").show()
		})
	})

	//Driver License picture

	jQuery("#image_url_driver_license_picture_btn").click(function(e) {
		e.preventDefault();
		var r = wp.media({
			title: "Upload Image",
			multiple: !1
		}).open().on("select", function() {
			var e = r.state().get("selection").first(),
				a = e.toJSON().url,
				t = e.toJSON().id;
			console.log(e.toJSON().id), jQuery("#driver_license_picture_attach_id").val(t), jQuery("#driver_license_picture").attr("src", a),jQuery("#driver_license_picture").show()
		})
	})
});