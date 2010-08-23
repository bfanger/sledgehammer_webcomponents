function ie6_hover_hack() {
	var rows = document.getElementsByTagName("tr");
	for(var i in rows) {
		if (rows[i].className == "row_odd" || rows[i].className == "row_even") {
			rows[i].onmouseover = function() {
				this.style.background = "#7bb2ef url('/images/th_hover.gif')";
			}
			rows[i].onmouseout = function() {
				if(this.className == "row_even") {
					this.style.background = "#e7ebf7";
				} else {
					this.style.background = "white";
				}
			}
		}
	}
}
ie6_hover_hack();
