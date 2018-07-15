
<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<li id="profile" >
    <div id="sidebarprofil">
        <figure class="profile-userpic">
        @if(Auth::user()->id_pegawai!=0)
            @if(Auth::user()->pegawai->gambar != null)
            <img src="{{asset('imageProfil/' .Auth::user()->pegawai->gambar) }}" class="img-responsive" alt="Profile Picture" fixed>
            @else
            <img src="{{asset('images/profile.png')}}" class="img-responsive" alt="Profile Picture" style="max-width: 100px;">
            @endif
        
        @else
            @if(Auth::user()->peminjam->gambar != null)
            <img src="{{asset('imageProfil/' .Auth::user()->peminjam->gambar) }}" class="img-responsive" alt="Profile Picture" fixed>
            @else
            <img src="{{asset('images/profile.png')}}" class="img-responsive" alt="Profile Picture" style="max-width: 100px;">
            @endif
        
        @endif
        </figure>
        <div class="profile-usertitle">
            <div class="profile-usertitle-name">
                @if(Auth::user()->id_pegawai!=0)
                {{ Auth::user()->pegawai->nama }}
                
                @else
                {{ Auth::user()->peminjam->nama }}
                
                @endif

            </div>
            <div class="profile-usertitle-title">
                Pusat Studi Biofarmaka IPB
            </div>
            @php
            $connected = @fsockopen("www.example.com", 80); 
            //website, port  (try 80 or 443)
            if ($connected){
                $is_conn = true; //action when connected
                fclose($connected);
            }else{
                $is_conn = false; //action in connection failure
            }
            @endphp
            
            @if($is_conn==true)
                <center class="profile-usertitle-title">
                    <i class="fa fa-circle text-success"></i> - online
                </center>
            @else
                <center class="profile-usertitle-title">
                    <i class="fa fa-circle text-failed"></i> - offline
                </center>
            @endif

        </div>
    </div>
</li>
