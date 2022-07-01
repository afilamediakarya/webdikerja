@extends('layout.auth')

@section('style')
    <link href="{{asset('css/pages/login/login-2.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('content')

<div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
	
    <div class="content order-1 d-flex flex-column w-100 pb-0" style="background-color: #0093DD;">
        <!--begin::Title-->
        <div class="d-flex flex-column justify-content-center text-center px-lg-0 px-7">
            <a href="{{'/'}}" class="display4 font-weight-bolder my-7 text-white" style="color: #fff;">
                <img src="{{asset('image/logo.png')}}" alt="">
            </a>
            <h3 class="display4 font-weight-bolder my-7 text-white" style="color: #fff;">BKPSDM</h3>
            <p class="font-weight-light font-size-h2-md font-size-lg text-white opacity-70">Kabupaten Bulukumba</p>
        </div>
        <!--end::Title-->
        <!--begin::Image-->
        <div class="d-flex flex-row-fluid bgi-no-repeat bgi-position-y-center bgi-position-x-center" 
            style="background-image: url(image/back.png); height:30px; background-size:contain">
        </div>
        <div class="d-flex justify-content-center">
            <a href="https://play.google.com/store/apps/details?id=com.afilamediakarya.dikerja" target="_blank">
                <svg width="304" height="118" viewBox="0 0 304 118" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <rect width="304" height="118" fill="url(#pattern0)"/>
                    <defs>
                    <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0_1641_3697" transform="translate(-0.0015) scale(0.00155263 0.004)"/>
                    </pattern> <a href=""></a>
                    <image id="image0_1641_3697" width="646" height="250" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoYAAAD6CAYAAAA89YbqAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAANhJJREFUeNrsnQucFNWZt98xKHIxghKUL7iA65U1goFdXDUq+/lLolkjBCNqgkh0veTLt15Wk5glQRY3qysqaBTvgCYSkygaN2ZVbprVSGAELyGCIAwgw8AIA8MwA3Pp7X9BtTVtT1d1d1Xf5nl+v56Zvkx3dZ3qPk+957zvqYjFYgYAAAAAcAC7AAAAAAAQQwAAAABADAEAAAAAMQQAAAAAxBAAAAAAEEMAAAAAQAwBAAAAADEEAAAAAMQQAAAAABBDAAAAAEAMAQAAAAAxBAAAAADEEAAAAAAQQwAAAABADAEAAAAAMQQAAAAAxBAAAAAAEEMAAAAAQAwBAAAAADEEAAAAAMQQAAAAABBDAAAAAEAMAQAAAAAxBAAAAADEEAAAAAAQQwAAAABADAEAAAAAMQQAAAAAxBAAAAAAEEMAAAAAQAwBAAAAADEEAAAAAMQQAAAAABBDAAAAAEAMAQAAAAAxBAAAAADEEAAAAAAQQwAAAABADAEAAAAAMQQAAACAMqFLZ3mjY8eOHdCtW7fRXbt2PSn++xiaHgAAANJRX1//x9bW1prGxsa5Tz/9dFVneM8VsVisbN/cFVdc8R99+/b9Zv/+/QccdthhXTjEAQAAIBuqq6sbN23atLKmpub2J5988mnEsERQZLBfv36zjz322NORQQAAAAibbdu2tbzzzjuzH3rooSsRwyLm6quvfnTEiBHf6datWwWHLQAAAEQtiEuWLLl51qxZ0xDDIkJRwiFDhiwfNGhQr1T319bW2ooVK6yqqsq5iK1btzoXAAAAAC8DBgywHj16JP4ePHiwnXjiida9e/eUj6+srFy+YcOGUeUwD7HkxXDcuHFjTz311J+nGjZ+7bXXnIukEAAAACAXhg8fbueee64jicloDuLixYtPLHU5LGkxlBSOHDlyTvLQcdzc7YknniAiCAAAAKGjCGLcQZxoohcNLb/55pvfLuXklJIVw1RSuHv3bkcIFSUEAAAAiJIxY8Y4Fy+lHjksSTHUnMIzzzxztXf4WFI4ZcqUxBxCAAAAgKhR9PDGG29sN/9Qchi/rXspvp+SXPlEiSZIIQAAABQa5THIQeQiLv369et20003LUMM84BK0nizj5FCAAAAKCRykAcffLDdbcOGDRt6+eWXX48YRoiGkFWn0Hub5hQihQAAAFBIli5das8880y724477rhJiGGEaEUTb7KJso9JNAEAAIBiQGKo2skuGuEstahhSYmhlrnzXle0EAAAAKBYSB5SLrWoYcmI4RVXXPEf3oQTRQqpUwgAAADFhLvSmouihpdeeukZiGHI9O3b95ve6wwhAwAAQDHy+9//vt313r17/wtiGDL9+/dPlBd31z4GAAAAKDaUiOKlT58+pyKGIaJsZO8wMlIIAAAAxYpK6XmHkwcMGHAEYhgi3bp1G+29TnkaAAAAKGb+8pe/eD2mQkEuxDAkunbtehJiCAAAAKVCQ0NDu+vJQS7EMAfiO/MYDjEAAAAoFbwRw1LiAJoOAAAAABBDAAAAAEAMAQAAAAAxBAAAAADEEAAAAAAQQwAAAABADAEAAAAAMQQAAACAgHRhFwDkn6FDh9qECRPsnHPOsd69e1tjY2Pivm7dutm7775rc+bMseeee87q6uoCPefll19uAwcOzGp7Fi1a5FzE2Wef7Vxyxfuc2Wz/rbfemvi7UNvUEdqW8ePH22mnnWaf+9znbPv27Tm3X6p9oP+dNm1a1v8/a9YsW7duHR84AAhOLBYr+st111236Kmnnoq5l8GDB8e06cV86THoiNiJE8fETn/+B7HTf/uD2BfuHBc76vKzYwf27lH0284luktcKGIrV66MbdmyJeZHXBZjNTU1senTp8d69erl+9xr1qyJZcsTTzyReB79HQZxscto33i3f+fOne3uK9Q2JV9GjRoVq62tdS5B2m/Tpk2x22+/PVD7pWrDbdu2OcdMNvtQr53J/3LhwiXci1zF6y7xk8nrS8G5GEqOgBOnXmNnvDLR7Fsn26bjDrJNxx5kjecfbX0nftXOev3f7PifjLEDD+vBjupExMXAZs6cac8++6wdd9xxTpTJj4MPPtj69u1rV155pX344YdOlLGz0NLSUnTtp0ij2vDwww93LkHar1+/fjqxdSKI2bSfosnxDsV5/UzxRqEBAILCUHLI9L/mVuv21b+zpY0LLFaxPyqr3/FLbXODfeYzB9j/ufyL9qVLT7O1D82ztff8np3WCaSwsrLSjjzySOvevXu7+3bs2GG7d+9OdOQahuzSpYv16NEj8Vj91mXevHmOJGp4EvLbfhK7/v37f+q+jz/+2Gk/tZm3/bziL0HU/6r9NHVg+fLlGcvhD3/4Q+cCAIAYltLO7NXHen37X+ytbT3jHftO69p1aUIKY/svLdZmVS3b7aMuB9ig6//BBl52lr1z85P28bw/swPLWAqPPvrodrdrTtqSJUtsxowZnxI9/c+oUaPslltusSOOOMIOPfRQ5/ZDDjnELrrookBiqOe/9957A2+nd97d448/7kQoUzF69Gg7+eSTE9dfffXVDufshTGXr9Db1JEU7tq1y15++WWbMmXKp0RPc/wuvfRS+973vudIncRQKMr44osv2nnnnZeRHOr/r776avvlL3+ZsVQCACCGBeTIS75nqyt6OiLY0DDW+X3QwUsTUmie382xmK1q3mJdD+1ix8+60lre22zv/r9Z1rimhh1ZRjz55JNOpNDLxo0b7fzzz++wk1fCgZIGdPnRj35kN998sxMxlIhIOILiTd7IhHQJGhJcr4Tpcdm+TilskyRccufS0NBgtbW1TvJJR0kduv2nP/2pPfDAA3bPPffYmDFjHKkXGlpesGCBs81+SSlbtmxxphK4gjp79mwbMmQIHyoAiBTmGIZp2V84zZpi+69IDneNtT17hn9KCmP6sf96k7XY282bbOPgrjbi9Yl2wvRxzD8sExT1O+OMMxJDwpKKVatW2Re+8IXAkR8Jxg033OBIoWQS8tt+EjEN67vtt3TpUmeuYJBMX4mfMs8V+a2vr0/cLtHUCYMfra2t7eRxwIABzokCAABiWCLUHdg9IYXu7931Y21v0/CUUuj9XRdrtMV71lvLhcfb31dOsYE3n8sOLXEeffTRdkkDGt4dMWJERuVLhCKHSGHh20+RQslipu13//33O9HDpqamxG2nn366b2khDSErYunOQdWUgptuuimrRBQAAMSwAPQceno7KXR/N+4ca82Sww6k0Blq3v/YjW077K0Da6z7TWfZl1bcbod9+W/YsSVIcs09SeG4ceMylgoonvZTjcBs20+JI4o4uihqeNddd/n+n6LFSlDy/h/JRwCAGJYIdW2flsKEHNbF5bBxWFopTMw/rGizNa0f29uH7bC/fupKG7bgB3bI3w1iB5cQKn7sLWlSXV0dajIGlF77KdrnjRqOHDnS/zslLqLf/e532wmp5lOGUewbAAAxjJhdbaml0P3dFJfDliQ5TJZC7++mWIstb9lk6/+mqw357xvtb35+lXU5nPmHpcBXvvKVxN8aCrzzzjvZKZ28/RTp80YNVasxSG1D/d/bb7+duJ5LbUMAAD/ISg4bVwRj+/9O+t20bax1jf/+TM/KtFLoPMX+33XWaG+2rLcjv9rfRrw9xaqffMM+vOU37OsixltcWDJQiGhh0MzcsJaJo/3So6if6h66kUhlKgeVOw1jL168OJGlTG1DAEAMS0UKY/5yuOfjsXZQ/M/PHFLpK4Xe2zbH6m1r1wbrf/UwO23M39oHP3nGtv7yT+z3IsRb4kSRoSBZrCtXrnSKIwdFUaRvfOMbHb7+pEmTAj8XYph7+wXBO5Ss5BJFDIPse73+9OnT7fvf/76ThEJtQwBADMtMDvfG5fDAA1LIYQdSaPuHnVsqYraubbtV9+lixzx4sfW/9h/sg+8/bbsWr2XfFylBlybTahleIfFDq2xA8bRfEDZv3tyu5mImw8EqXXTVVVclCp5T2xAAooA5hmFLYfLvNHMOm7eOtZZdwwJLoVVUJB6j+Yfvtm22dSd3tRNfucFOeIr5h8VKVALnrqgBpdN+ycXOM81yTi6XQ21DAAgbIoZRyGFylNCsw8hhy5Z9K6Qc8NnKwFLo/a35h0taN9qRXzvKhv/DbbZ59uu28T9/by0fN9AWBcQ7ZKjhYdWs8xuOlOh1tOyb97n+6q/+yvlby7J1hMqrdDTMnExYw6Sdvf2C4F1DWa+R6TCwHq9kFC2NqMLpbm1D1UmkFBIAIIalIIVB5LBmrH1mvxxmIoXmyWrW/MPagxus/7XDbPiFf2vr7vq9bX5gEW1SILRqhVcGVF5EharT4a6Q0hGSk7feequdsKSDeYPhtJ9WPgnSfn5o6Peggw5KXNdqKNnIpmobKmvaPV7c2obaxnQnCwAAQWAoOWwxTDN0nO6+1s1jrW3nsKyk0KXF2pz5h8sP32G9bv+aDf3DD63XV0+iXQrAvHnz2l3Xese5oo7fO6ypqCBE334SsDDaT8PA3vbLNqmF2oYAgBh2IjmM7RiWlRR60frL77dtdeYfDvz1lXbCnKvs4GOPoG3yiDJIVZrEpV+/fjl33IoUeecVJssnhIeSOsJsP0ULp0yZ0i4q/NJLL2X9fIoQeqcduLUNe/bsSeMBAGJYVFKYqxxWj7U2Rw6zk8J2kYVYoy1v3WR15x1lJ/3hZht4x4UkqOQJzQXzikWuRYklJUcddVTiuqKFM2fOZEdHRPIwfK7tpzmAffr0add+kydPzmkbx4wZY1u2bGm3jUcffTSNBwCIYbnJYdumsRarG5aTFHrR/MPlB9eaXTvMhi6eaEd+92zaKQ+ozpx3uFdRp3fffTdjuVCtuxdeeKFdKZsNGzZQvy5iLrzwQtu6dWvi+mc/+1mnyHSm7aes4S9/+cvtor2vv/56zsks+n+dHLjHmJ7fu7IKAABiWExSmLMcXtRODrOVQhd3/uF7feqZf5gnFHV6/vnn22W49u/f31asWBF4WFJSoSFj7xCh5pZpLV+Ivv0kgloSTygJ5fOf/7wj90GWspNAPvPMM3bjjTe2W3dZIjdu3LhQtlErn+zcuTNxXdsIAJALZCVHIYcZZCSnuy/20UX7RpR7V+YkhV7c+Ye9Tu7mzD9seW2trb7+l9b0QQ1tFwETJkyw0047zREKt9NW5PDZZ591on5anUQC4k0kUPaxxHHq1KlO5rFb0NiVwokTJwaKFgZdEs+VILKYP40ETvta9QJd8dJlwYIFtmTJEpsxY4Yz38+LpFHR4rFjx1rXrl3bzSvU9IJzzjkn1NIyWi7vV7/6VbtSOAAAiGGxSmGucrjxon33H1YZ6qbum3/YaH3OOMyGvvVjp7QN9Q+jYcSIETZ//nwbPHhwYjhRw8K6PP744052qkqXuGgNXclHcvkarcAhKbz//vt9XzPTJfE0Nw0xTPE5iQucRE9yKPHylojR8LDadu/evYn2O/DAAx2Zl/wno1IyksKwpwCo3X73u98lahsCAOQCQ8lhi2GWQ8dp75Mcbh8WySbXxhrszdb1zvzD4X++jfmHEcnFsGHDnDp4XgF0BUPCITFzL14BcdHwo0qUBJFCiEYOFSVMLhGkaK63/ZQglCyFmkpQVVVlX/rSlyKbF6qM9T179tBYAIAYdho53BCdHArNP1x6cI0z/3D48luZfxgB1157rX3961+3d955p11SQ0dobpuiTBp2/uIXv5hzgeVSotjWgZYcnn/++c5qMqtWrQrUfjt27HBEUqWLND0gUynMZB9o+77zne+0O/HIZN1tAAAXhpLDlsIch47T3rdh/7By78pINl8JKpp/2HPQQXYM8w8jQcN+Q4YMcUTh0ksvta997Ws2aNAg5z4NFUsG9Hv16tU2Z84cZ/5a0PloKl+SbTmVoBmyP/nJT5zh70z/L8rtj3KbUrXf8ccf70QQL774YkcWJWBqM1fmJGeVlZXOvL/k+YdRtqFeSyceXshcB4CMVSYWixX9Rl5//fWLRowYcZZ7/bbbbnMyO4uO5bFPxM797f07rPuO+lVkcuilT0UPO+aAw5l/CAAAkCGaV6554S4vvfTSDbNmzZpW7NvNUHKomp3idwkOK7skzz/sf8t5tDEAAEAZgxgih7648w8PvuUsO3XNHcw/BAAAQAwhKyksEznU/MPVbR/b8sN3OPUPVSCb9ZcBAAAQQ+ikcihUIFvrL687uatT//CYhy5j/WUAAADEEDKSwjKSQ6EC2Zp/2HTJ8cw/BAAAQAyhs8uh2Ni2g/mHAAAAiCEgh/tINf+w54hBHAcAAACIIULYGeVQeOcfnjDvBjthzlXMPwQAAEAMkcPOKodC8w+Xtm60uvOOcuYfDrzjQo4LAAAAxLCTSiFy6LA5Vu/MP1SB7FuqbrTLvt6HYwQAAAAxRA47qxxq/uGhu1faD2ofs9m3HWlLfz3UThvak+MEAAAAMUQOO5scDmnaYovWz7FDm3eYNb5nwwats9d/cYLNve8E69O7C8cKAAAAYljmQogcfiKFVXOsV+ueT25srTNrWGqjvlRna+cPt2k/GmhduiCIAAAAiCFyWLZy6EjhuiQp9NK82XrGltp1l5itXzTUrht/JMcOAABAgSFUE5UcxpL+Tndbqt8WwX2SQ9G7MnopXBuXwrY97aU4mViL2d511q/nZpv2g4E2btSRduu96+y/FtZxDHXAwIEDnUuvXr1s6NChidvXrVvnXMSiRYvYUQAAgBgWpRB2Mjl0pPDDAFLopa3JrOl9G/bXveyFBwfac/Ob7Id3rrOVa5s6/SF19tln26hRoxwJPOusswL/X1VVlSOIujz33HNWV4dsAwAAYogc5lEOE1LYmoEUetH8w8blNuqsI+2cM06yx35da7f9bKPVbm/pVIeQIoK33nqrI4SHHnpoVs8xYMAAGz9+vHOZOXOmPf/88zZr1ixHEgGSj7fLL7+8w/sVidaxU27oMxY22lfLly93LlFvn9rEHSUAQAyLXQo7oRwOafRECnOlZbP1PKDWrvt2f7voa0Ptjgc32vRZm8v+8FF0UJ1BJpHBoFxwwQXORZHE66+/HkGEdmI4adKkDu9/9dVXy1IM073nXNmxY0ciWp/tvvPbPj0/YghRQPJJFHLo/d3R32WUkOJI4Zo0iSbZ4M4/POQ9m/avvWzpb4faP/7fXmXbMasDWbhwYSRS6EWRxLlz5zqdil4XAMJHkX6diClaL3lLF5EFQAyRw7KSQ0cKV4cshe0Esclsz/s27Lh19sIjcYF69CQ7/uiDy+ZQUfROw07qRPKJBFSvq9cHgGhPxiSI+rx5E8YAEMPOJISdRA4dKfwgQin0ovmHTXGBOnOzvb9wqE2bNND6HFa6MyGUVawo4T333JP1PMIwohp6fQ11aXsAIDqGDBliy5YtI3oIiCFyWJ5y6EjhqjxJYTtBrDVrfNOuG2/27ivD7YKvlN76y5IwDeXmO0rYEUpQ0fYghwDRo+ghcgjFDMknUclhkIQTv/uLNCHFkcKVGZakCZvmdXbkZzfbcw+fYNdP7mLTHy+N5BQNJUnCso0SKhFAQ1IqP+PWLvTWNFQCi/7O9PkVzdD/kpQCkB85FOWY1AOIIfgJYZnJ4ZDdnkhhRYH3tzP/cLlNm3SCbd/ZYk/8praoDw8le2QjhW6pGf1vR/UIk4VOcqiohC5BXm/ChAlIIUCe5TCs0jYAYcJQchRymO7vEh5WdqRwZQGGj/3Y+77df1v/op5z6M4pzEQKZ8+ebYMGDXLqGWZapNpNLJGMTp482SmfkU4KiVwAtGfkyJFWUVER+NK7d28bPXq087kNCp87QAw7ixSWoRw6Uvh+EUrhfnoetM6+Nbp45xuqA9BwbRDefvttO+WUU5xoX651yiSTqo0oQVTkESkEiAZ91nQCp8+tTuj0OfZD3wnMNwTEEDksOTksdil0aKuzzx9RnCukKHIXNNFE0QYNA4c9vKROS5FHiSBSCBAtOqHT5zhI9DCKFVgAEEPkMDI5nHV3lS36/gfWq6G16Hd7fX3xrQesSJ1KwgRBohZ19EAiqGgkUggQPfo8+0UOVeeQ+oaAGJa7EJaJHM761Z02vvJl6/VhN7OZw8yaincOX9Mesw/XF1/EMKh85VPUFI1ECgHyJ4dhPAYAMUQOCyqHM5++0y6LS2GCzYcUtRxuqDb73cLi2iYN3QZZ4m769OmIGkCZohMxvyFlIoaAGCKHRS2HM395p41f+opZrCJRPSchh48Xnxx+XGf2Lz81q9tZXIdBkLlDqkvIsnQA5Y1fKaio10gHQAyLSQhLTA5nzrnTLotLYUIIU8nhY8Uhhy2tZjW1ZtdNMXthQXEdCioW7ZeFrBIyDCEBlD+qQQqAGCKHJSeHj8+ZauOWvJIosl3Mcqjo4Op1Zv/0r2a/+G3xHQZBooDTpk3LuRwNABQ/mdQgBUAMy1EKS1AOH/vFVLvsT684N8Q8VphWDh/NvxzubjL7qMbsjkfM/n6s2QsLi+8wUDFrv/I0ihZKDAEAAIoJlsSLQg6zXf4u1/uzXD7vsZ/vk0LnaoXtl8OYVey/P/EUksP4jRXJcvhPlWbdos0I3ttstr3e7OXXzX58n1nVR8V7CCjpxA8lm3SWKIJK9rhrOKeaZK/9oAn6Gm7L95Cbtkfbpm1MtW2K6Lrblu+ly3QcuduXjLs9pbCMofse9Fv7uZTfSy77oBg/izqJdae86GTVXYe9UJ9HQAyRwyKQw8eemGrjFr+S2PRYLEM5rI7L4SNxObwqGjnUPMIdcSFcvtLs32aYvba0+Js/VUeeTLlHC9XhSGw0pB5kxRdFWCdNmuR0ThIE7Z+oREzbpu3S/E7VkEuHkgLGjx/v/F1VVZXYtqimAKjjVtKS9l265RPdZAU38qyLe6KRrjN3l0rMR/tnso/d96ITpnKcYuH3naBjK0rcddPTJbnoeHPvT/486phM1yZqa78T4jBWcvI7vt0TzSAn54AY5lcIS0QOH519l417c1578ctWDh/eL4fdw5HDtjaznbvNaraZTXnQ7Bf/VT6dgArelvPcQnUS6kgyWRfa2zlJxHRRxnZYnYlXVnTJZtskONddd51zUfkRPU9YUV9tm4TIldBM9pc6cFfC1IkXOsNVbZ/NPtbjtW/1PrQvymlFED8Zj+okSFHBTJbjTPd5VFkttUmqY17b71fIX+2aa5v6ya3IZK1qSA1zDKOQw+S/i3DO4T4p3J99HKtI+KJ55ND9h0BzDl05bMz9XGNXXAg/2GB2x2Nmp15SWlLoCkQuZ7yliqJdbgeRjXiliiStXbs2lAiXu8ygJCqMbVNHKWENIzKh59BzZSqFyR343LlzC5rl7rZ/rvvYlV09l4S51JEM+X0nRDGMrmNh2bJlWUthMpJ2tUmqYXF9p+lEzm97wnhPQfY3IIbIYYZy+Oisu+zbf/QMH4cphw9lL4dNe81qPo6f8f3W7CtXm90eF8O6+tJq+iDDyOUohq54hdUJeZFoKuqRrSS4HaRf55ytjOXSEUl69RxhyKqYOXNm2bS/nkuflVTzEkvp+0CS60fYYqiIaxTHgj5DapNUcuhXpF//m8uJlI4Dv2ih5JRKD7nDUHKUcliEw8qPOFI4LyF+FRWfyF6F5LAilvuwsuTwmuDDys48wl1mf1gWl4Cfm732VnkfGmEmnajjCSKjYUQ90m2DOraw5CYViqZ1lLziJ4VRy5I6fnVamUZE1HkrClMOJwWShSjaX3KoY0vHWKkla0mCgqxopKHPMN+bjsMojyu1s9pbbeIdAtd79YuOutMdsj2JyuV7ChBD5DDFbY/MjEvhG/P237Tvxsjk8MG4HF6bXg7deYQaNp4+x+wXL5Z+k+c7Yhg0IpErHWUoSgqilkKvJKjzCSpg+ZBCr7iqkwyaVBR1550vFMWNuv29clgKuAlEQacGhCkzeu18JLapvfVZTD5R02unm2uopBZtYzZRPb/PvRJ4yKJGDItbBItMDh9+PC6Fr89L2F6h5VDzCD+qjZ9l/lf8Yb8pvSFjyE4Knn/++XZRBj1HkFViMhWwTDtIN/vS22G5pT2CDkGrQ3TLfKRDnWkmwup2eN5t03P41crMB5KDoPvHzerWPtJ7cdtekbUgmcsSqHxGhCQimchopseyUEJHmEOfmSR9adjVPVa1DTredfHLiPcKu/aRNyrqRg3T/b+bAJZpW/htE9FCxBA5zOD+hx+725HCfdJn+ZPDTXE5nBGXw+9+IoeaR6h6hM/Gv4/u/Hm8s9jEIVMqUZBUX8RBpCBVSZVUsqT7g2TU6nWTJS6VsATp3CQrer50Q37qKPWYIB2+G0VJNzQYZHjR7bj1uh2JpptlnY+IcSokQUHkVO2v7Uz1vtWObka12j9dm+l96jnyNYcsl2SgIKg6QdilgyTdficzOjnT66bbj0Haw/0settVx73aNN2+03NnI4ZBTuwgHEg+iUoO092Wx4SUhx+92771P/MSN3qTSD75syIhfu1uDyMhRXL4wDBr2dXFtm43++83zC6eaPa9/0QKS1kMdT3IUKg6P3doLZ0suR3ahAkTfJ9TnVW66ECQkhZCc7vcch7pUIejx02ePNn3OdUhp+v0tG1BBFOvpf2RLvqo/an9cMoppzgdY74JEqFx299vH+t+vV+/91EuUSGdkEQxNC6Z0/4ePXq0I4DJ6PPlZsH7tYeeR+3nd7wnJ5T4tZE+v5nMxw2SdJLupBMQQ+TQ8/dDj7hS6Apd/uWwNf7gTesOssoZA+2Kfzcb/YPyTi4JUo+slLMsM5WCTJMG1CFJdIJEczraj0GiEZJCdU6ZbJvecxBxTff6QfabXiMTAXKlOp9yqNfz66wzbf8gxbfTtXupkM3nIlN0MiNhGzRokDNcrWNDohg0Wu2eeGg7/YpvJwuupDOVlCafIAUlyOc5k/cFiGGnlcOHHt4nhZ8WuvzJYW1Ls/1p1067e9N6O/WZ1fbCH8q/yYN82Zd6x6YhTL9hNjcikk3nJ0G44YYbsuowFNnzi8i5hbOzQR2QXwHdjiIiQebS6bmz6eS0z/JZwzDI0F4m7e9GboPMvczHyi1RIWHSfsnXcLheR/srm6x59/vMb3+nqhTgN79XJxVBvwf9StzoM0OJGsQQOfS5/8G4FF76h/lphC5aOdzZ2mIrGhtsVk21nfeXZXbXpqpO09xBvqBKJbuyo/cVpBZZptG4VB2LX8HcVNsRpPPLVaDUUfpF57LZNncuXi5RIr99FhZ+x7Df1AHvPpHUqs5k0Dl9hSzinS06UdLwro6LQgx56jXd13UTTNxkHrfigJs4ov3rlT0dV+mO91SRYz2f3zB0kKh4kJMpooXhQ/JJvuQwTwkpD85QpHB+QuI6TiLZn3Ri4SWk7Im12samPfZmQ51N3bTO3mnY1emaOogYZlqLLx1hlWfQF3C6SJv3fQVZ8i+M7fJLRlGH4RZWDrptYUQX1MFq29IlfaTaDr9tC2OeVNAEnlzQPk/XWbtrHneExMRNOMl22cTkdi9mIXSTpQo5B86NGKZbuzr5uPGuDa59nelx5VdkW985Gn1It1/8TgLC+q4BxLBs5fDBGffsixRakuhFLIctbTGrbtljf9m9y35Ws8Fe3L61Uze1ojbpvkSVyen3hZiJGIbxxZhJFNNPbMM6g1enpM4pnYQkC4LfMHJY26bnSSeGyfKiv/0kKIxtc6M7UdYV9BsC1PGY6tiWCKijz7bMjo4FyYb2U7EmGmgbdeKhfeCW5ikkmdZUTD7xctcGz2b+qtopXWazbk9XBFzb7nes5KNmY2eEoeR8y2G623IYVp4hKXxtviUP6yb+jGhYeUvzXvtTww776cYP7bz33+r0Uuh2zn6EscZu2FEgv84+qHyFeQbv91xeSclncXF1/n5DZd5t85MpPVdY86SijqD4HSvJdSolJnpvWvovGynUvDwNw7q1KfMlhSNHjnROnjO5uLUv9Z4LLYXuMH0YZXeyPdHwEze/DH4/CWcYGTEsTfHLgxw6UvjqfI/XRS+H9S2t9t7uXfZgzQb7elwIH9mykfbPoGMupnlSftEsb1ZikPWKw+wQ/WQpk0SesOff+W2bV6D8ZCrMyfOFFhI3S1qd9vbt253IaqbrVCtCpWxaZdXqJIoadZkLmYZx87EiUS5iqJPMjj4bft+RSCFiiBx2cP+MB6bZJa/OTxhb1HK4N9ZmHzQ12G/rttioVctsykdrrK61hXZP6hj9SjxoqLlYklD8voC9ohvm/Mh8i2EU7VwuMpcJficHkoGFCxdmFamSvKtcj1u8m2zTzFG0sliWW1R01y+LP1XUMEjSCcPIiCFymOLvB+53pdBTVDoiOWyN/9i4t8le3bnNrl77Z5uw5l1bv6eRts7hS6tYvtj8hrWZ3A2ZiGE20UHJg+pXupFGyI58rZ0e5nehTiCSjym/k1UdLxS0RgyRw6TbHvhZXAoXzf90yZgI5HDr/nmEt2/60P5xZaW9Xr+d9vVBnZvfhG0NoxS6Jlu6LEUX7zBeviNbfhHBQkaUwoyellJty7D2uaLqqlfpZsyWUtS0WAlaGN3d9x3No9Ttut9vHm0Q1K5+0zi8IkjSCWKIHGYhh/fHpfDiRfOThC58Oaxrbbb3dtfbQ1vX26hVlfbo1g20aUDckiZ+3HPPPXkfnnXRWbrfNmriv/fMPMhZej6FKRNJCbuMi9+2eUUnk/mI5S6ZivZIPPKdTFLu6BjyO8Z1surKuPZ9R6MBul336znVVn5TY/zIJAnFbwRDkslJBGKIHHrk8P77ptklCxckiV+4ctjQ2mofNO2232zbbGNWv2X//tFq2xGXRMj8yzBImQd9CQdJ6ggbRTX9JqenmvSf6RJZueD3XF7hCjLkHZaAqWP1y872bpufGOq5wjoGop67mk2nrGNG6z8rmUTRIaYnhE+QSgd6TKbRtjC+n9zSUx2hUQv3uPUbRSFaiBgih56/7793ml0cl8JEQkjIctgSf4KqvY02b2etXbvuXfv/VX9mHmEOKBISZGhHcpZvOZQU+g3XdFQOwq9TDyvjOsgE9GRJ8Rv6CmvoPsh79G5bEBEKo4SROtdM5/hFKYaK7rilZtyyNRANQYq7ZyPket4wspv9vgv1mfI7ft2i24AYIodxfjZ9mo1dsKC90IUoh9V799jS3Tts0kcr7ZI1b9kbu5hHGAZBlnYTihipw83HsLJkL0jGaEdf5H6di95LGFErP4lTJ5EsKX7bpved61CrmzGbDg3BB7ktk44zjH0WBpI7v6ixIuWKDuo4yLYjVzsVIpJermSb1BPWiZ7f0nr6bPp9BogWIoblJ39ZyuF906fbxQsWJolfOHKoIeI/N9bbfTVr7RsfLLVfb6umHUNGX6xBhpR1piyxiapzVyer5w8ihZLZjjqSIB29/jeXTl37wG++VKrtCNL55Zr1mm41h3Tb5rff1P65yKEkLNtVRbLp5NPhrvySy7HqrhxSimuLlwva92EUyBYaQfH77KX7zPsttQiIYaeRw/umxaVw/oL0K5FkIYeNbW32wZ4GeyYugt9cs9Tu3bKWeYQRRliCnnWrQ1VCigQuzCQCvb62I0gChr6A08lpkNpkkpxsI0USCu2DIIKWTNAakrlET/w6yo46sCCZ6io1kk2ERvssn0NsQSI3er/ZyqH+V5FnHUeqiajXI3qYG5l+n0RxTOUS8Sv0etOIIRSFHLpS2F7qcpPDvXEh3DePcKt9r+pdu27De7ZhL/MI8xFhUeHeoEhe1q5d63SQ2UZM1JG6QpjJKgiSQr95ZEEiW3oPep5MOvSgiQkS047mqwXZNsldplFNPa/2Yy6dX5COUa+RSdRYHbj2WT5XudC+9zs5cOfOZiKHblQ7OfKpgs1ED/3bxO+4DHq8R3VMBTlucvnOAcSwrOXwvrvvtbGJSKHlLIcqUF3d3GRv7Npmkze9b99aW2lvNGyjnfKIRCQTOXQFRhETfaHq/yVOHXW0+tJXxympkIhqOTJJRibJCFqGLEg0Tdujx/qhqI8bMU3XKSmaoW0OIrCKuqXrJLT9QeZ1at9KNvwidNqn6iSDFA5WtDKd/Gm7g5T+cKPG6UTIXYc431LofS9+EVBXDvVYPynxi2p7o4fwafxOqNQWfnLtHlPLli2L7JjKJlqv+bkkLuWPLuyCiOUwlvn998al8CInUhh/QEXMeUiFVw518/5/lvhVVHwih87t8Rv3PWYfHzfvtXXNu21u3SZ78uMNDBkXWA7dqFAmqFOUyIQ13ycVOpPPJFKlDiRI5rA6GL1ft26aOid9ybvJBeqo/Eq/JL+uXyeh9xFEmLTt2jZXsPS8bhKQti3I+0uWG7/hLj1GguOHBEmPU6a1tk3P6+43bV9Y2aK5RH+03/yG/bWNkmpd1MFr/+q96JLNe2FIOTU6sfKb/+rKtZvd6z1W1Q75mKOqY1knbpnUFeVkADHs1HJ47/5IYUL0YtnLYX2sxWqa99h/76ixhz9eZxv27qY9ikQO3YnYhV7k3kXRv0yTXvQeJE5BI1Z6jDqeXDofyWuQTkLyofcTVMBd8c4F1ekLMgyux6jIcJB5lELSnIk45xO1RSZJL7m2vyS50KsFFStuUf0gkW0d74VcT1nffUHFUBJL3cv8wlByvuQwwP1OpHDewvZDwc6PTxehTjesvCfWZuv3NtqLcSH85w1v24+rVyCFRXh2rw41jCWnckFDgRrezrazDTIUGxaZSkE2Q/e5CGsmc6DUgWc716rYUPvn4zjWa+gzQwJC+uMq11VK8iWGQbeTuYWIYaeVw+lxKfzmvP3DS7GKrOSwpS1mm5ub7I+7ttm/bX7frlm/zP7IPMKixR2yVKSpELgdba4lICS5WjYrSEmeXMQrGynIhxwq2pqNHOt/ykEO1SZqmyDzOpHC6NtCUfwwP4sa/o+ibYN87+h9UNAaMeyUcjj9rnvtolcWthe/DOVwW2uzLW+ss/trP7QJ65fas3Ufsb9LBJ0RqxhwviRBX7aSUUlpWGuOutmnUUSOtK1B5u6l64DCWO811X7Uqh65DG3qfUlcw+rI8xUh7UgOgyQk5eukoDOfcGp/hXFM6fMc1YhAkCVDWUsbMSxb8Uv3mGl33WfffGWheY0vEznc1dZiK5vqbc62DXblhrfsga1rSC4pQdzMXVcQo4i+uULoLk8WxXuQHGr+XBjbryjFKaecEsq2uuIaVnRWbeRmUocROdG25RKVcSW10AWAJcmS8DAiTBJ5PVcuJwWdWQ51fPqttpMO/W+UQq4kIr+5yRS0Lgwkn0Qhh7Fgj5k29T5nTuG+OoOxfc64P8skkWwiOayIJXzSTUjZa622qbnRKndvt/tqV9uKpp3s+zISRDcjVpdcJuu7QzHuJR/oLN8traNLpokTki79f9gTzt21q73blknGsVu4Wu8v7NIZej51wm65oaBt7rav/ifbDlz/l07kMo0qu2V2Mn0v3hMC7eeopcBPXgsto7lunzusnGk7KEqoz4n3+yKskQUvfid86WqVQsQaE4vFin4j4wf1ohEjRiRSmG677TZbsWJF8W3ohk8VFuy487zzk0hhhSfduMIrj+YJMO6Xw9Z4e21t3WMr4yL48LY1Nq9+C0dxJ0Bf7ooqueU90nUGbjkY/Y7iCz1TtM3qoNJtu1vGJt/zidxSKe6+7Wh/avvymRnpnhhou1LtM+82JQtCuu90dbb5Shbyvhd3H3dUQ889Vt2SQRDdMaXjPLkd3O8L93OYj23Ra6aLGCpaXOrZyIMHD7aJEycmrr/00ks3xE94ir72DhHDyJS7Yzm8Jy6FF76y0PNF7sph+sjhtrY9tmbPLvtdfbXNqF3NPu5E5FtMwkQdQLHWISsWeU4lpNlEzPxq/BVCuvRe8hmxhnCPqShQBDOdFCpaSokaxLDTyOHdihS+vMgxwZgnQphODuvbWqy6udEW7Kqxe2pXMocQAFLit/wcc/WgGPCLWjO3sLCQfBImzXtTy2GSFMZc6bOKtGsbN8fabN2eBnupvtqu/miJ3VrzHlIIUGZoWE/RtDBW9NBQYTqKMToKnU8K083tVdIRYlhYiBiGyZ4mswMPSimHd99xn13oRAr3S6A50wZTRg7b4nfUNDfZqr077bFta2z+rhr2LUAZIQlUB6khNbeT1GT8XFf18BNDhueg0PglnSCFhYeIYZgsW5zy5rvu+FlcCl9NiJ9LqshhbeseW7Z7u02rXWmXrn8DKQQoIzTUq45Pc/20JJ43cqIlyvyGgtPhlcxURFmAGiAIio77VQJgXeTCQ8QwTD7e2oEULvpkDeNUaxvHf+yKtdrG5gZ7sX6TPbp9te1kyBig7PBbV9ot9ZLpkK+E0i8SQ/IHFJogJWqYB1t4iBiGydLXzVpa2knhmJcWJRWubr+2seYRrtm7y16ur7bLN/7R7q79C1IIUKb4RUMkjW4x7kyk0E84BUN0UEhUJuess87KSRwBMSw95j5lVr3B+XPq7ffHpfDVT4QwSQ5b43991Nxob+zeajdvfsv+uXqJbWzezT4EKHMx9FsVRoK3bNkyp5NMVVvR29Hq+fRYPykkEgOFxk/6NNWBGpbFAUPJYbIz/sX70FT719gRNuaNd/cNE1fsHz42N9nEbHNLk33U0mC/3lllT9WtZb8BdBIkZ0o6mTt3ru9jJ02a5FySa7q5BaODrigjEc01qQUgF3QSM378eN+TJkAMy5PZD9iWvz7dVjZ3t76f6WYHVRzgzCdstTZraGuJS+Fue3HXJnt6x1rb2caQMUBnQ3P9FMHz6yhdNPzmNwSXjlyWywMIA7+6hSpRwxxYxLCseWTN6/bigT3svB6ft8Fd99Umq2rZZR/urbdFDZsRQgA6Sud3UDnM+jx1/7rTAIVCEW6/iDXRQsSwU/BRc4M9UreKHQEABZHDQqyLDJCMamummwOrqQ6cvBQXJJ8AABRQDidPnhz68+o5kUIoBoIUtGaqA2IIAACejvOUU04JpQC1nkPPRdkPKJYTHwpalx4MJQMAFBgVtFamsS6aj3XBBRdk9P/PP/+808Gy5B0UE4oEpouIqzwNJWoQQwAA6ACJnS5uSRoVr9ZF11N1qO7jAYoRZRqTbYwYAgBAjijSQqcKAIWAOYYAAAAAgBgCAAAAAGIIAAAAAIghAAAAAJSsGDY2Nq6mqQAAAKBUOPHEExHDqNizZ8973ut+BTMBAAAACkmPHj3aXW9sbJyLGIZE8s5EDAEAAKCY8UYM4x4Te/rpp6sQw5DQzty2bVuLe33w4MEccQAAAFCUdO/evV0Qq6qqqqZUtr1kkk82btyYMO0+ffoghwAAAFCUDB8+vN312traNxHDkNmyZcuvvdfPPPNMjjwAAAAoOs4999x217dv334XYhgyjz322C3e4WSJ4ec+9zmOPgAAACgaNKLpHUZeu3Zt3VNPPfU/iGEEfPDBB697r1922WUcgQAAAFA0XHPNNe2ur1q1anIpbX9JiWF1dfV4Zfa414cNG8aQMgAAABQFY8aMcfIgXBQtnDVr1jTEMCKUnbx48eLHvbcpakj5GgAAACgkSjiRGHoptWhhyYmheOihh66UgbvXlRL+4x//GDkEAACAgiAHSR5CrqysXF5q0cKSFEPx9ttvD/UmoiCHAAAAUAiUbCIHkYu4VFdXN06dOvWUUnw/JSmGGlJ+8803v+2db+jKIXMOAQAAIB9o6HjixImfksLFixefWKrvqSIWi5Vsg4wbN27syJEj53Tr1q3Ce3tlZaU98cQTtnXrVo5aAAAACBVFCeMO8qmRSo1mKnD15JNPPo0YFlAOTz311J8fdthhXZLve+2115zLihUrOIoBAAAgJ5RgouLV3nWQXdxIYamsiVy2YijGjh07YMiQIcsHDRrUK9X9tbW1jhxWVVU5F6FoIhFFAAAASEaRwB49eiT+VoRQMugdMvaiRJMNGzaMKnUpLBsxdLn66qsfHTFixHeSh5YBAAAAwkZDx0uWLLm5FLOPO4UYCkUP+/XrN/vYY489PdXwMgAAAECuQvjOO+/MVgm9cntvZSeGXq644or/6Nu37zf79+8/AEkEAACAbNEcwk2bNq2sqam5vZSTSzq1GHpRJLFbt26ju3btelL89zEc4gAAAJCO+vr6P7a2ttY0NjbOLYf5g4ghAAAAAATmAHYBAAAAACCGAAAAAIAYAgAAAABiCAAAAACIIQAAAAAghgAAAACAGAIAAAAAYggAAAAAiCEAAAAAIIYAAAAAgBgCAAAAAGIIAAAAAIghAAAAACCGAAAAAIAYAgAAAABiCAAAAACIIQAAAAAghgAAAACAGAIAAAAAYggAAAAAiCEAAAAAIIYAAAAAgBgCAAAAAGIIAAAAAIghAAAAACCGAAAAAIAYAgAAAABiCAAAAACIIQAAAAAghgAAAACAGAIAAAAAYggAAAAAiCEAAAAAIIYAAAAAgBgCAAAAAGIIAAAAAIghAAAAACCGAAAAAIAYAgAAAABiCAAAAABlwv8KMADLbPZ1PyQJdgAAAABJRU5ErkJggg=="/>
                    </defs>
                </svg>                    
            </a>
        </div>
        <!--end::Image-->
    </div>
    <!--begin::Aside-->
    <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
        <!--begin: Aside Container-->
        <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 ">
            <!--begin::Logo-->
            <a href="#" class="text-center pt-2">
                <!-- <img src="assets/media/logos/logo.png" class="max-h-75px" alt="" /> -->
            </a>
            <!--end::Logo-->
            <!--begin::Aside body-->
            <div class="d-flex flex-column-fluid flex-column flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin py-11">
                
                    <!--begin::Form-->
                    <form method="POST" action="{{route('do-Login')}}" class="form" novalidate="novalidate" >
                        @csrf
                        <!--begin::Title-->
                        <div class="text-center pb-8">
                            <h2 class="font-weight-bolder text-dark font-size-h1">Selamat Datang</h2>
                            <h2 class="font-weight-normal text-dark font-size-h6">Silahkan masukkan NIP dan Password anda</h2>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-normal text-dark">NIP</label>
                            <input class="form-control form-control-solid h-auto py-5 px-4 rounded-sm" value="{{ old('username') }}" type="text" tabindex="1" name="username" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-normal text-dark pt-5">Password</label>
                                <a href="javascript:;" class="text-primary font-size-h6 font-weight-light text-hover-primary pt-5" id="kt_login_forgot" tabindex="-1">Lupa Password ?</a>
                            </div>
                            <input class="form-control form-control-solid h-auto py-5 px-4 rounded-sm" type="password" name="password" tabindex="2" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Action-->
                        <div class="text-center pt-2">
                            <button type="submit" class="btn btn-dark btn-block font-weight-bolder text-white font-size-h6 px-8 py-4 my-3" style="background: #0093DD;">Masuk</button>
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
                <!--begin::Forgot-->
                <div class="login-form login-forgot pt-11">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                        <!--begin::Title-->
                        <div class="text-center pb-8">
                            <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password ?</h2>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                            <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Submit</button>
                            <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->
            </div>
            <!--end::Aside body-->
        </div>
        <!--end: Aside Container-->
    </div>
				<!--begin::Aside-->
				<!--begin::Content-->
    
    <!--end::Content-->
</div>
@endsection

@section('script')
    @if(Session::has('error'))
          
        <script>
            let message_ = '{{session('error')}}';
            Swal.fire(
                "Maaf anda gagal login",
                message_,
                'error'
            );
        </script>
    @endif
    <script>
        "use strict";

// Class Definition
    var KTLogin = function() {
        var _login;

        var _showForm = function(form) {
            var cls = 'login-' + form + '-on';
            var form = 'kt_login_' + form + '_form';

            _login.removeClass('login-forgot-on');
            _login.removeClass('login-signin-on');

            _login.addClass(cls);

            KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
        }

        var _handleSignInForm = function() {
            var validation;

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validation = FormValidation.formValidation(
                KTUtil.getById('kt_login_signin_form'),
                {
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'Username is required'
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'Password is required'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                        bootstrap: new FormValidation.plugins.Bootstrap()
                    }
                }
            );

            // Handle forgot button
            $('#kt_login_forgot').on('click', function (e) {
                e.preventDefault();
                _showForm('forgot');
            });

            
        }


        var _handleForgotForm = function(e) {
            var validation;

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validation = FormValidation.formValidation(
                KTUtil.getById('kt_login_forgot_form'),
                {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'Email address is required'
                                },
                                emailAddress: {
                                    message: 'The value is not a valid email address'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap()
                    }
                }
            );

            // Handle submit button
            $('#kt_login_forgot_submit').on('click', function (e) {
                e.preventDefault();

                    swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        KTUtil.scrollTop();
                    });

            });

            // Handle cancel button
            $('#kt_login_forgot_cancel').on('click', function (e) {
                e.preventDefault();

                _showForm('signin');
            });
        }

        // Public Functions
        return {
            // public functions
            init: function() {
                _login = $('#kt_login');

                _handleSignInForm();
                _handleForgotForm();
            }
        };
    }();

    // Class Initialization
    jQuery(document).ready(function() {
        KTLogin.init();
    });

    </script>
@endsection