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

          <label class="pt-2 pl-3 pr-2">Book:</label>
          <form class="col-md-3">
            <select class='form-control' v-model='book' @change='getChapter()'>
              <option value="0">Select Book</option>
            </select>
          </form>

          <label class="pt-2 pl-3 pr-2">Chapter:</label>
          <form class="col-md-3">
            <select class='form-control' v-model='chapter' @change='getHadithNum()'>
              <option value="0">Select Chapter</option>
            </select>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- main section -->

  <div class="card container-fluid mt-3" style="display:flex;border:3px solid #c3e6cb;border-radius:20px">
    <div class="card-body">
      <div class="row container-fluid ">
        <div class="col-1">
        </div>
        <div class="col-5">
          <h4 class="pb-3"><b>Narrated 'Umar bin Al-Khattab:</b></h4>
          <h6 class="text-left">I heard Allah's Messenger (ﷺ) saying, "The reward of deeds depends upon the intentions and every person will get the reward according to what he has intended. So whoever emigrated for worldly benefits or for a woman to marry, his emigration was for what he emigrated for."</h6>
        </div>

        <div class="col-5">
          <h3 class="pb-3"></h3>
          <h5 class="text-right">حَدَّثَنَا الْحُمَيْدِيُّ عَبْدُ اللَّهِ بْنُ الزُّبَيْرِ ، قَالَ : حَدَّثَنَا سُفْيَانُ ، قَالَ : حَدَّثَنَا يَحْيَى بْنُ سَعِيدٍ الْأَنْصَارِيُّ ، قَالَ : أَخْبَرَنِي مُحَمَّدُ بْنُ إِبْرَاهِيمَ التَّيْمِيُّ ، أَنَّهُ سَمِعَ عَلْقَمَةَ بْنَ وَقَّاصٍ اللَّيْثِيَّ ، يَقُولُ : سَمِعْتُ عُمَرَ بْنَ الْخَطَّابِ رَضِيَ اللَّهُ عَنْهُ عَلَى الْمِنْبَرِ، قَالَ : سَمِعْتُ رَسُولَ اللَّهِ صَلَّى اللَّهُ عَلَيْهِ وَسَلَّمَ، يَقُولُ : " إِنَّمَا الْأَعْمَالُ بِالنِّيَّاتِ، وَإِنَّمَا لِكُلِّ امْرِئٍ مَا نَوَى، فَمَنْ كَانَتْ هِجْرَتُهُ إِلَى دُنْيَا يُصِيبُهَا أَوْ إِلَى امْرَأَةٍ </h5>
        </div>
        <div class="col-1">
        </div><hr>
        <div class="row container-fluid">
          <div class="col-1"></div>
          <div class="col-md-4">
            <h5 class="pt-3"><b>Explenation:</b></h5>
            <p>The father being mentioned only once does not mean that there is deficiency in his right to good treatment, rather, the point is to show the greatness of the mother’s right. </p>
          </div>
          
          <div class="col-1"></div>
          <div class="col-4 pt-3">
            <b>Reference:</b> <span>Sahih al-Bukhari 1</span><br>
            <b>Book num:</b><span> Book 1, Hadith 1</span><br>
          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- main section -->

  <div class="card container-fluid mt-3" style="display:flex;border:3px solid #c3e6cb;border-radius:20px">
    <div class="card-body">
      <div class="row container-fluid pb-3">
        <div class="col-1">
        </div>
        <div class="col-5">
          <h4 class="pb-3"><b>Narrated 'Umar bin Al-Khattab:</b></h4>
          <h6 class="text-left">I heard Allah's Messenger (ﷺ) saying, "The reward of deeds depends upon the intentions and every person will get the reward according to what he has intended. So whoever emigrated for worldly benefits or for a woman to marry, his emigration was for what he emigrated for."</h6>
        </div>

        <div class="col-5">
          <h3 class="pb-3"></h3>
          <h5 class="text-right">حَدَّثَنَا الْحُمَيْدِيُّ عَبْدُ اللَّهِ بْنُ الزُّبَيْرِ ، قَالَ : حَدَّثَنَا سُفْيَانُ ، قَالَ : حَدَّثَنَا يَحْيَى بْنُ سَعِيدٍ الْأَنْصَارِيُّ ، قَالَ : أَخْبَرَنِي مُحَمَّدُ بْنُ إِبْرَاهِيمَ التَّيْمِيُّ ، أَنَّهُ سَمِعَ عَلْقَمَةَ بْنَ وَقَّاصٍ اللَّيْثِيَّ ، يَقُولُ : سَمِعْتُ عُمَرَ بْنَ الْخَطَّابِ رَضِيَ اللَّهُ عَنْهُ عَلَى الْمِنْبَرِ، قَالَ : سَمِعْتُ رَسُولَ اللَّهِ صَلَّى اللَّهُ عَلَيْهِ وَسَلَّمَ، يَقُولُ : " إِنَّمَا الْأَعْمَالُ بِالنِّيَّاتِ، وَإِنَّمَا لِكُلِّ امْرِئٍ مَا نَوَى، فَمَنْ كَانَتْ هِجْرَتُهُ إِلَى دُنْيَا يُصِيبُهَا أَوْ إِلَى امْرَأَةٍ </h5>
        </div>
        <div class="col-1">
        </div><hr>
        <div class="row container-fluid">
          <div class="col-1"></div>
          <div class="col-md-4">
            <h5 class="pt-3"><b>Explenation:</b></h5>
            <p>The father being mentioned only once does not mean that there is deficiency in his right to good treatment, rather, the point is to show the greatness of the mother’s right. </p>
          </div>
          
          <div class="col-1"></div>
          <div class="col-4 pt-3">
            <b>Reference:</b> <span>Sahih al-Bukhari 1</span><br>
            <b>Book num:</b><span> Book 1, Hadith 1</span><br>
          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- main section -->
  <div class="card container-fluid mt-3" style="display:flex;border:3px solid #c3e6cb;border-radius:20px">
    <div class="card-body">
      <div class="row container-fluid pb-3">
        <div class="col-1">
        </div>
        <div class="col-5">
          <h4 class="pb-3"><b>Narrated 'Umar bin Al-Khattab:</b></h4>
          <h6 class="text-left">I heard Allah's Messenger (ﷺ) saying, "The reward of deeds depends upon the intentions and every person will get the reward according to what he has intended. So whoever emigrated for worldly benefits or for a woman to marry, his emigration was for what he emigrated for."</h6>
        </div>

        <div class="col-5">
          <h3 class="pb-3"></h3>
          <h5 class="text-right">حَدَّثَنَا الْحُمَيْدِيُّ عَبْدُ اللَّهِ بْنُ الزُّبَيْرِ ، قَالَ : حَدَّثَنَا سُفْيَانُ ، قَالَ : حَدَّثَنَا يَحْيَى بْنُ سَعِيدٍ الْأَنْصَارِيُّ ، قَالَ : أَخْبَرَنِي مُحَمَّدُ بْنُ إِبْرَاهِيمَ التَّيْمِيُّ ، أَنَّهُ سَمِعَ عَلْقَمَةَ بْنَ وَقَّاصٍ اللَّيْثِيَّ ، يَقُولُ : سَمِعْتُ عُمَرَ بْنَ الْخَطَّابِ رَضِيَ اللَّهُ عَنْهُ عَلَى الْمِنْبَرِ، قَالَ : سَمِعْتُ رَسُولَ اللَّهِ صَلَّى اللَّهُ عَلَيْهِ وَسَلَّمَ، يَقُولُ : " إِنَّمَا الْأَعْمَالُ بِالنِّيَّاتِ، وَإِنَّمَا لِكُلِّ امْرِئٍ مَا نَوَى، فَمَنْ كَانَتْ هِجْرَتُهُ إِلَى دُنْيَا يُصِيبُهَا أَوْ إِلَى امْرَأَةٍ </h5>
        </div>
        <div class="col-1">
        </div><hr>
        <div class="row container-fluid">
          <div class="col-1"></div>
          <div class="col-md-4">
            <h5 class="pt-3"><b>Explenation:</b></h5>
            <p>The father being mentioned only once does not mean that there is deficiency in his right to good treatment, rather, the point is to show the greatness of the mother’s right. </p>
          </div>
          
          <div class="col-1"></div>
          <div class="col-4 pt-3">
            <b>Reference:</b> <span>Sahih al-Bukhari 1</span><br>
            <b>Book num:</b><span> Book 1, Hadith 1</span><br>
          </div>
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
