from .models import Hospitals,Ecommerce_user_hospital_link

def get_hospital(request):
    hospitals = Hospitals.objects.all()
    hospital_list = list()
    response = {}
    for hospital in hospitals:
        response['id'] = hospital.id
        response['name'] = hospital.name
        hospital_list.append(response)
        response = {}
    return hospital_list

def get_hospital_link(user_id):
    hospital_link = Ecommerce_user_hospital_link.objects.filter(user_id=user_id)
    link_arr = []
    if len(hospital_link) > 0:
        for link in hospital_link:
            hospital = Hospitals.objects.get(id=link.hospital_id)
            links = {
                'hospital_id':link.hospital_id,
                'hospital_name':hospital.name,
                'hospital_address':hospital.address,
                'hospital_city':hospital.city,
                'hospital_website':hospital.website
            }
            link_arr.append(links)
    else:
        links = {
            'hospital_id':'0',
            'hospital_name':'No Hospital Linked',
            'hospital_address':'              ',
            'hospital_city':'              ',
            'hospital_website':'              '
        }
        link_arr.append(links)
    return link_arr
