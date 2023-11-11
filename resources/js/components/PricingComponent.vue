<template>
<div id="app" class="container-fluid pt-3">
  <h2 style="font-family:inter" class="text-center">Pricings</h2>
  <p class="text-center container text-left pt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here,</p>
  <table class="table table-hover table-bordered" style="text-align:center; padding-top:100px">
    <thead>
      <tr class="active">
        <th style="background:transparent">
          <center></center>
        </th>
        <th>
          <center>
            <h3><strong>Basic</strong></h3>
          </center>
        </th>
        <th>
          <center>
            <h3><strong>Standard</strong></h3>
          </center>
        </th>
        <th>
          <center>
            <h3><strong>Business</strong></h3>
          </center>
        </th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td><b>Price</b></td>
        <td><p><strong>£0/Month</strong></p></td>
        <td><p><strong>£5/Month</strong></p></td>
        <td><p><strong>£15/Month</strong></p></td>
      </tr>
      <tr>
        <td><b>Standard Islamic Content</b></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Responsive design</b></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Modern and clean UI/UX</b></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Scales to all devices</b></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Powerful Analytics</b></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Remove Ads</b></td>
        <td>-</td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Video Content</b></td>
        <td>-</td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Video/Audio Podcasts</b></td>
        <td>-</td>
        <td>-</td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Chat Collection</b></td>
        <td>-</td>
        <td>-</td>
        <td><i style="color:limegreen" class="fa fa-check fa-lg"></i></td>
      </tr>
      <tr>
        <td><b>Saved items</b></td>
        <td>20</td>
        <td>40</td>
        <td>Unlimited</td>
      </tr>
      <tr>

        <td></td>
        <td><Button label="Select Package"  style="background:rgba(34,179,127,255)" rounded/></td>
        <td><Button label="Select Package"  style="background:rgba(34,179,127,255)" rounded raised/></td>
        <td><Button label="Select Package" style="background:rgba(34,179,127,255)" rounded raised/></td>
      </tr>
    </tbody>
  </table>
</div>
</template>

<script>
export default {

}
</script>

<style>
table {
  table-layout: fixed;
  word-wrap: break-word;
  margin-top: auto;
  margin-bottom: auto;
}

.text-sm {
  font-size: 12px;
}

.price {
  font-size: 3em;
}
</style>
