
document.querySelector("#fetch").addEventListener('click', () => {
    fetch('./api/fetchStdents.php').then((res) => {
        return res.text()
    }).then((data) => {
        return JSON.parse(data)
    }).then((data) => {
        return data.data
    }).then((data) => {
        let dom;
        data.map((item) => {
            dom += `
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            `
        })
    })
})