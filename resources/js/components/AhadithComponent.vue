<template>
<div id="app">
  <h2 class="pt-3 pb-3 text-center"><strong>Ahadith</strong></h2>

  <!-- multiple input sections -->
  <div class="row text-center container-fluid">
    <div class="col-md-12 text-center" style="padding-top:10px; box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;">
      <div class="row ">
        <div class="col-md-12 mb-2 container" style="display:flex;text-align:center">

          <label class="pt-2 pl-3 pr-2" style="display:flex">Imam:</label>
          <form class="col-md-3">
            <select class="form-control" v-model='imam' @change='getBook()'>
              <option placeholder="Select Imam" value="0"><span>Select Imam</span></option>
            </select>
          </form>

          <label class="pt-2 pl-3 pr-3">Chapter:</label>
          <form class="col-md-3">
            <select class='form-control' v-model='chapter' @change='getHadithNum()'>
              <option value="0">Select Chapter</option>
            </select>
          </form>

          <label class="pt-2 pl-3 pr-3"></label>
          <form class="d-flex col-md-4 ml-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Search Keyword" aria-label="Search">
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- main section -->

  <div class="card container mt-3" style="display:flex;border:3px solid lightgrey;border-radius:10px;">
    <div class="card-body">
      <div class="row">
        <div class="col-9 mt-1 font-weight-bold">
          <h3><b>1) Revelation</b></h3>
        </div>
        <div class="col-3">
          <div class="alert text-center" style="background:#a3cfbb;color:#343a40;border:3px solid #c3e6cb;" role="alert">
            <b>Bukhari - Book 1 - Revelation</b>
          </div>
        </div>
      </div>
      <hr class="container">

      <div class="row container-fluid">
        <div class="col-6">
          <h5 class="pb-4"><b>Narrated 'Umar bin Al-Khattab:</b></h5>
          <h6 class="text-left">I heard Allah's Messenger (ﷺ) saying, "The reward of deeds depends upon the intentions and every person will get the reward according to what he has intended. So whoever emigrated for worldly benefits or for a woman to marry, his emigration was for what he emigrated for."</h6>
        </div>
        <div class="col-6">
          <h4 class="pb-5"></h4>
          <h5 class="text-right">حَدَّثَنَا الْحُمَيْدِيُّ عَبْدُ اللَّهِ بْنُ الزُّبَيْرِ ، قَالَ : حَدَّثَنَا سُفْيَانُ ، قَالَ : حَدَّثَنَا يَحْيَى بْنُ سَعِيدٍ الْأَنْصَارِيُّ ، قَالَ : أَخْبَرَنِي مُحَمَّدُ بْنُ إِبْرَاهِيمَ التَّيْمِيُّ ، أَنَّهُ سَمِعَ عَلْقَمَةَ بْنَ وَقَّاصٍ اللَّيْثِيَّ ، يَقُولُ : سَمِعْتُ عُمَرَ بْنَ الْخَطَّابِ رَضِيَ اللَّهُ عَنْهُ عَلَى الْمِنْبَرِ، قَالَ : سَمِعْتُ رَسُولَ اللَّهِ صَلَّى اللَّهُ عَلَيْهِ وَسَلَّمَ، يَقُولُ : " إِنَّمَا الْأَعْمَالُ بِالنِّيَّاتِ، وَإِنَّمَا لِكُلِّ امْرِئٍ مَا نَوَى، فَمَنْ كَانَتْ هِجْرَتُهُ إِلَى دُنْيَا يُصِيبُهَا أَوْ إِلَى امْرَأَةٍ </h5>
        </div>
      </div>
      <hr class="container">

      <div class="row container-fluid">
        <div class="col-4 pt-3" style="background:lighgrey">
          <b style="background:lighgrey">Narrator:</b> <span style="background:lighgrey">Sahih al-Bukhari</span><br>
          <b style="background:lighgrey">Reference:</b> <span style="background:lighgrey">Sahih al-Bukhari 1</span><br>
          <b style="background:lighgrey">In-Book Reference:</b><span style="background:lighgrey"> Book 1, Hadith 1</span><br>
          <b style="background:lighgrey">Hadith Num:</b> <span style="background:lighgrey">1</span><br>
        </div>
      </div>

    </div>
  </div>

</div>
</template>

<script>
import axios from "axios";

export default {
  mounted() {

  },
  data() {
    return {

    }
  },

}
</script>
