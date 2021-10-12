function bursaryVerification() {
    return fetch('../../api-endpoints/bursary-verification.php');
}

function bursarySetStatus(regNo, status) {
    return fetch('../../api-endpoints/set-bursary-clearance-status.php', {
        method: 'POST',
        body: JSON.stringify({
            regNo: regNo,
            status: status
        })
    }).then((response) => location.reload()).catch((error) => console.error(error));
}

function librarySetStatus(regNo, status) {
    return fetch('../../api-endpoints/set-library-clearance-status.php', {
        method: 'POST',
        body: JSON.stringify({
            regNo: regNo,
            status: status
        })
    }).then((response) => location.reload()).catch((error) => console.error(error));
}