require 'ServerPilot'

CLIENT_ID = 'cid_IIQ3qWQlBRAN3B3X'
API_KEY = '1ro7a9s1Tr0Yw6MM63Ys8G0iTTjuV2sHsMEun5UEaTM'

sp = ServerPilot::API.new(CLIENT_ID, API_KEY)
# sp.scheme = 'https'

# If you want to list all servers
action = sp.get_servers

action.to_h.each { |k,v|
    if k == :body
        puts "Existing Servers:\n" + JSON.pretty_generate(v['data'])
    end
}

action = sp.get_sysusers

action.to_h.each { |k,v|
    if k == :body
        puts "Existing Users:\n" + JSON.pretty_generate(v['data'])
    end
}

action = sp.get_apps

action.to_h.each { |k,v|
    if k == :body
        puts "Existing Apps:\n" + JSON.pretty_generate(v['data'])
    end
}