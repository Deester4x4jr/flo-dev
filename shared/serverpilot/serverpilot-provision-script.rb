require 'ServerPilot'
require 'logger'

log = Logger.new('/home/vagrant/log.out')
log.progname = 'ServerPilot'
log.level = Logger::DEBUG

CLIENT_ID = 'cid_IIQ3qWQlBRAN3B3X'
API_KEY = 'N6AbidaNSRnh7iKCE8bPCWh4ChVnvZQSjMkgx0V65ZE'

sp = ServerPilot::API.new(CLIENT_ID, API_KEY)
sp.scheme = 'https'

# server_list = sp.get_servers

# server_list.to_h.each { |k,v|
#     if k == :body
#         log.info "Existing Servers:"
#         log.info JSON.pretty_generate(v['data'])
#     end
# }

# log.info "\nConnecting this Server...\n=========================\n"

# begin 
#   new_server = sp.post_servers {name: 'test-connect-server'}
# rescue Exception => e
#   log.error e
# else
#   log.info new_server
# end