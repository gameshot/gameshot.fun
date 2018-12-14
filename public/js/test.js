let xhr = new XMLHttpRequest();
xhr.open("POST", "https://discordbots.org/api/getInvite", true);
xhr.onload = function () {
    let res = JSON.parse(this.response);
    console.log(res);
}
xhr.setRequestHeader("Content-Type", "application/json");
xhr.send("accessToken=NTIzMDg5NDY5Nzg0NzE5MzYx.DvUf2A.XfrmpDv-7kxyWK5kOIOk9IHGHNI");
xhr.send("inviteCode=jyTN5WR");