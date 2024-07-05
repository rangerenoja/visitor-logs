const count_reg_filePath = "database/count-reg-visitor.php";
const count_vip_filePath = "database/count-vip-visitor.php";

// Function to fetch VIP visitor information
function get_reg_Info() {
    return fetch(count_reg_filePath, {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse the response as JSON
    })
    .catch(error => console.error('Error:', error));
}

// Function to fetch VIP visitor information
function get_vip_Info() {
    return fetch(count_vip_filePath, {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse the response as JSON
    })
    .catch(error => console.error('Error:', error));
}

// Function to display VIP visitor information in the VIP table
function display_reg_Info(data) {
    const dataSize = Object.keys(data).length;
    console.log('Size of regular visitor data:', dataSize);
    const total_reg_visitor = document.getElementById('total-reg-visitor');
    total_reg_visitor.textContent = dataSize;
    return dataSize;
}

// Function to display VIP visitor information in the VIP table
function display_vip_Info(data) {
    const dataSize = Object.keys(data).length;
    console.log('Size of VIP visitor data:', dataSize);
    const total_vip_visitor = document.getElementById('total-vip-visitor');
    total_vip_visitor.textContent = dataSize;
    return dataSize;
}

// Call the getInfo function to fetch and insert VIP visitor info
Promise.all([get_reg_Info(), get_vip_Info()])
    .then(([regData, vipData]) => {
        const totalRegularVisitors = display_reg_Info(regData);
        const totalVIPVisitors = display_vip_Info(vipData);
        const overallTotalVisitors = totalRegularVisitors + totalVIPVisitors;
        const overallTotalVisitorElement = document.getElementById('overall-total-visitor');
        overallTotalVisitorElement.textContent = overallTotalVisitors;
    });
