var ctx = document.getElementById("myPieChart").getContext("2d");

var myPieChart = new Chart(ctx, {
  type: "pie",
  data: {
    labels: ["Produk", "Member", "Transaksi"],
    datasets: [
      {
        data: [produk, member, transaksi],
        backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
      },
    ],
  },
});
