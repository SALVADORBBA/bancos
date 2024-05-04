CREATE TABLE banco( 
      descricao varchar  (255)   , 
      id number(10)    NOT NULL , 
      status number(10)    DEFAULT 2 , 
      numero varchar  (255)   , 
      logo varchar(3000)   , 
      ambiente number(10)    DEFAULT 2 , 
      apelido varchar  (100)   , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE bancos_modulos( 
      id number(10)    NOT NULL , 
      numero varchar  (255)   , 
      descricao varchar  (255)   , 
      status number(10)    DEFAULT 2 , 
      logo varchar(3000)   , 
      ambiente number(10)    DEFAULT 2 , 
      apelido varchar  (100)   , 
      system_unit_id number(10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE beneficiario( 
      id number(10)   , 
      nome varchar  (255)    NOT NULL , 
      tipo_pessoa varchar(3000)    NOT NULL , 
      cpf varchar  (11)   , 
      cnpj varchar  (14)   , 
      insc_estadual varchar  (20)   , 
      data_nascimento date   , 
      endereco varchar  (255)   , 
      cidade varchar  (100)   , 
      estado char  (2)   , 
      cep varchar  (8)   , 
      telefone varchar  (15)   , 
      email varchar  (255)   , 
      system_unit_id number(10)    NOT NULL , 
      numero varchar  (20)   , 
      complemento varchar(3000)   , 
      bairro varchar  (20)   , 
      cmun number(10)   , 
      cuf number(10)   , 
      instancename varchar  (255)   , 
      urlexterna varchar(3000)   , 
      apikey varchar(3000)   , 
      rotaexterna varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE boleto( 
      id number(10)    NOT NULL , 
      nossonumero varchar  (200)    NOT NULL , 
      codigobarras varchar  (200)    NOT NULL , 
      linhadigitavel varchar  (200)    NOT NULL , 
      pdfboleto varchar(3000)    NOT NULL , 
      pdf_nfe varchar(3000)   , 
      status varchar  (200)    DEFAULT 'Em Aberto'  NOT NULL , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      valor varchar  (50)    NOT NULL , 
      data_vencimento varchar  (50)    NOT NULL , 
      dataemissao varchar  (50)    NOT NULL , 
      xml varchar(3000)   , 
      cliente_id number(10)   , 
      datavencimento_interno date   , 
      data_baixa timestamp(0)   , 
      mensagem_baixa varchar  (255)   , 
      parametros_banco_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id number(10)    NOT NULL , 
      beneficiario_id number(10)    NOT NULL , 
      system_unit_id number(10)   , 
      nome varchar(3000)    NOT NULL , 
      razao_social varchar(3000)   , 
      cpf_cnpj varchar  (20)   , 
      insc_estadual varchar(3000)   , 
      email varchar(3000)   , 
      criado_em timestamp(0)   , 
      alterado_em timestamp(0)   , 
      fone varchar(3000)   , 
      cobranca_cep varchar(3000)   , 
      cobranca_endereco varchar(3000)   , 
      cobranca_bairro varchar(3000)   , 
      cobranca_uf varchar(3000)   , 
      cobranca_cidade varchar(3000)   , 
      cliente_situacao_id number(10)    DEFAULT 1 , 
      cobranca_cuf varchar  (2)   , 
      cobranca_lat varchar  (30)   , 
      cobranca_lng varchar  (30)   , 
      cobranca_cmun number(10)   , 
      cobranca_email varchar  (200)   , 
      cobranca_numero number(10)   , 
      observacoes varchar(3000)   , 
      cobranca_complemento varchar  (100)   , 
      status number(10)   , 
      paises_codigos varchar  (20)   , 
      number varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cobranca_titulo( 
      id number(10)    NOT NULL , 
      beneficiario_id number(10)    DEFAULT NULL , 
      system_unit_id number(10)    DEFAULT NULL , 
      parametros_bancos_id number(10)  (11)    NOT NULL , 
      cliente_id number(10)    DEFAULT NULL , 
      valor binary_double  (10,2)   , 
      data_vencimento date    DEFAULT NULL , 
      novaDataVencimento date    DEFAULT NULL , 
      emissao_tipo number(10)    DEFAULT 1 , 
      bancos_modulos_id number(10)    DEFAULT NULL , 
      status number(10)  (11)    DEFAULT 1 , 
      tipo number(10)    DEFAULT 1 , 
      identificacaoboletoempresa varchar  (255)    DEFAULT NULL , 
      created_at timestamp(0)    DEFAULT CURRENT_TIMESTAMP , 
      updated_at timestamp(0)    DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP , 
      valorabatimento binary_double    DEFAULT NULL , 
      seunumero varchar  (255)    DEFAULT NULL , 
      caminho_boleto varchar(3000)   , 
      user_id number(10)    DEFAULT NULL , 
      data_baixa timestamp(0)    DEFAULT NULL , 
      descricao_baixa varchar(3000)   , 
      numero_bb varchar  (255)    DEFAULT NULL , 
      DataDoProces timestamp(0)    DEFAULT NULL , 
      qrcode varchar(3000)   , 
      linhadigitavel varchar  (255)    DEFAULT NULL , 
      codigobarras varchar  (255)    DEFAULT NULL , 
      digito_verificador_global varchar  (11)    DEFAULT NULL , 
      modelo number(10)    DEFAULT NULL , 
      avalista_id number(10)    DEFAULT NULL , 
      identificador varchar  (10)   , 
      txid varchar(3000)   , 
      nossonumero varchar  (50)   , 
      pdfboletobase64 varchar(3000)   , 
      xml_create_boleto varchar(3000)   , 
      xml_response varchar(3000)   , 
      xml_alteracao_boleto varchar(3000)   , 
      xml_baixa_boleto varchar(3000)   , 
      url_bb varchar(3000)   , 
      emv varchar(3000)   , 
      databaixa date   , 
      horariobaixa time   , 
      id_titulo_empresa varchar  (255)   , 
      url_imagem varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE controle_meu_numeros( 
      id number(10)    NOT NULL , 
      parametros_bancos_id number(10)    DEFAULT NULL , 
      ultimo_numero varchar  (20)   , 
      numero_anterior varchar  (20)   , 
      created_at timestamp(0)    DEFAULT CURRENT_TIMESTAMP , 
      updated_at timestamp(0)    DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP , 
      status varchar  (20)    DEFAULT 'livre' , 
      system_unit_id number(10)    NOT NULL , 
      banco_id number(10)  (11)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE eventos_boletos( 
      id number(10)    NOT NULL , 
      linhaDigitavel varchar  (255)   , 
      codigoBarras varchar  (255)   , 
      caminho_pdf varchar(3000)   , 
      data_cadastro timestamp(0)    DEFAULT CURRENT_TIMESTAMP , 
      parametros_bancos_id number(10)  (11)   , 
      system_unit_id number(10)  (11)   , 
      documento_id varchar  (255)   , 
      mensagem varchar(3000)   , 
      codigo varchar  (50)   , 
      updated_at timestamp(0)    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP , 
      created_at timestamp(0)    DEFAULT CURRENT_TIMESTAMP , 
      qrCode varchar(3000)   , 
      txid varchar  (255)   , 
      cobranca_titulo_id number(10)  (11)   , 
      url_banco varchar(3000)   , 
      numerocontratocobranca varchar  (50)   , 
      codigocliente varchar  (50)   , 
      numerocarteira varchar  (50)   , 
      numerovariacaocarteira varchar  (50)   , 
      seunumero varchar  (30)   , 
      caminho_boleto varchar  (255)   , 
      nosso_numero_banco varchar  (255)   , 
      print varchar  (10)    DEFAULT 'no' , 
      titulo varchar  (255)    DEFAULT 'Create' , 
      user_id number(10)  (11)   , 
      prorrogacao_data timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE layout_bancos( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    DEFAULT NULL , 
      bancos_modulos_id number(10)  (11)    DEFAULT NULL , 
      logomarca varchar  (255)    DEFAULT NULL , 
      codigo_layout varchar  (255)    DEFAULT NULL , 
      tipo_layout varchar  (50)    DEFAULT NULL , 
      nome_arquivo_php number(10)   , 
      nome_arquivo_css varchar  (255)   , 
      status varchar  (20)   , 
      imagem_layout varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE manual_integracao( 
      id number(10)    NOT NULL , 
      banco_id number(10)    NOT NULL , 
      arquivo varchar(3000)   , 
      create_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE paises_codigos( 
      id number(10)    NOT NULL , 
      codigo number(10)    DEFAULT NULL , 
      fone number(10)    DEFAULT NULL , 
      iso varchar  (2)    DEFAULT NULL , 
      iso3 varchar  (3)    DEFAULT NULL , 
      nome varchar  (255)    DEFAULT NULL , 
      nomeFormal varchar  (255)    DEFAULT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE parametros_bancos( 
      id number(10)    NOT NULL , 
      banco_id number(10)    NOT NULL , 
      beneficiario_id number(10)    NOT NULL , 
      system_unit_id number(10)    DEFAULT NULL , 
      workspaces_santander_id number(10)   , 
      numerocontrato varchar  (100)    NOT NULL , 
      numerocontacorrente varchar  (100)    NOT NULL , 
      modalidade number(10)   , 
      identificacaoboletoempresa number(10)    DEFAULT 0 , 
      identificacaoemissaoboleto varchar  (100)   , 
      identificacaodistribuicaoboleto varchar  (100)   , 
      tipodesconto varchar  (50)   , 
      diasparadesconto_primeiro number(10)    DEFAULT 1 , 
      valorprimeirodesconto binary_double   , 
      dataprimeirodesconto date   , 
      diasparadesconto_segundo number(10)   , 
      datasegundodesconto date   , 
      valorsegundodesconto binary_double   , 
      diasparadesconto_terceiro varchar  (255)   , 
      dataterceirodesconto date   , 
      valorTerceiroDesconto binary_double   , 
      tipomulta varchar  (50)    DEFAULT '0' , 
      tipojurosmora varchar  (50)    DEFAULT '0' , 
      diasmultas number(10)    DEFAULT 5 , 
      valormulta number(10)    DEFAULT 0 , 
      diasjurosmora number(10)    DEFAULT 0 , 
      valorjurosmora number(10)    DEFAULT 0 , 
      codigoprotesto varchar  (11)    DEFAULT '50' , 
      numerodiasprotesto number(10)    DEFAULT 0 , 
      codigonegativacao varchar  (50)    DEFAULT NULL , 
      numerodiasnegativacao number(10)    DEFAULT NULL , 
      gerarpdf varchar  (10)   , 
      ambiente number(10)    DEFAULT 2 , 
      client_id varchar  (255)    DEFAULT NULL , 
      apelido varchar  (20)    DEFAULT NULL , 
      carteira varchar  (50)    DEFAULT NULL , 
      certificado_base64 varchar(3000)   , 
      agencia number(10)    DEFAULT 6789 , 
      digito_agencia number(10)    DEFAULT 3 , 
      digito_conta varchar  (10)   , 
      username varchar  (200)   , 
      password varchar  (255)   , 
      scope varchar(3000)   , 
      info1 varchar  (80)   , 
      info2 varchar  (80)   , 
      info3 varchar  (80)   , 
      info4 varchar  (80)   , 
      info5 varchar  (80)   , 
      mens1 varchar  (80)   , 
      mens2 varchar  (80)   , 
      mens3 varchar  (80)   , 
      mens4 varchar  (80)   , 
      cooperativa varchar  (10)   , 
      posto varchar  (10)   , 
      status number(10)  (11)   , 
      codigobeneficiario varchar  (20)   , 
      cpfcnpjbeneficiario varchar  (20)   , 
      client_secret varchar(3000)   , 
      chave_pix varchar(3000)   , 
      client_id_bolecode varchar(3000)   , 
      client_secret_bolecode varchar(3000)   , 
      observacao number(10)   , 
      senha_certificado_pix varchar  (100)   , 
      certificados_pix number(10)   , 
      tipo_chave_pix varchar  (20)   , 
      certificado varchar(3000)   , 
      senha varchar(3000)   , 
      etapa_processo_boleto varchar  (20)    DEFAULT 'validacao' , 
      versao varchar  (10)   , 
      sistema_origem varchar  (50)   , 
      autenticacao varchar(3000)   , 
      usuario_servico varchar  (255)   , 
      unidade varchar  (20)   , 
      authorization varchar(3000)   , 
      gw_dev_app_key varchar(3000)   , 
      numeroconvenio varchar  (20)   , 
      numerovariacaocarteira varchar  (20)   , 
      indicadoraceitetitulovencido varchar  (1)    DEFAULT 'S' , 
      numerodiaslimiterecebimento varchar  (10)   , 
      codigoaceite varchar  (20)   , 
      tipos_documentos varchar  (100)   , 
      valorabatimento binary_double  (10,2)   , 
      baixa_devolver_codigo number(10)  (11)    DEFAULT 1 , 
      baixar_devolver_prazo number(10)  (11)    DEFAULT 30 , 
      protesto_prazo varchar  (20)   , 
      protesto_codigo number(10)  (11)    DEFAULT 0 , 
      url1 varchar(3000)   , 
      url2 varchar(3000)   , 
      url3 varchar(3000)   , 
      url4 varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE parametros_itau( 
      id number(10)    NOT NULL , 
      banco_id number(10)    NOT NULL , 
      beneficiario_id number(10)    NOT NULL , 
      numerocontacorrente varchar  (100)    NOT NULL , 
      digito_conta number(10)    DEFAULT NULL , 
      agencia varchar  (20)    DEFAULT NULL , 
      digito_agencia number(10)    DEFAULT NULL , 
      system_unit_id number(10)    DEFAULT NULL , 
      tipos_documentos_id varchar  (100)    DEFAULT '2 COMMENT Espcie do Documento. Informar valores listados abaixo' , 
      numerocontrato varchar  (100)    NOT NULL , 
      certificado varchar(3000)   , 
      senha varchar  (200)    DEFAULT NULL , 
      modalidade number(10)    DEFAULT '1 COMMENT Nmero que identifica a modalidade do boleto. Infomar' , 
      tipomulta varchar  (50)    DEFAULT '0' , 
      tipojurosmora varchar  (50)    DEFAULT '0' , 
      diasmultas number(10)    DEFAULT 5 , 
      valormulta number(10)    DEFAULT 0 , 
      diasjurosmora number(10)    DEFAULT 0 , 
      valorjurosmora number(10)    DEFAULT 0 , 
      negativar varchar  (11)    DEFAULT '50' , 
      numerodiasnegativar number(10)    DEFAULT 0 , 
      client_id varchar  (255)    DEFAULT NULL , 
      username varchar  (50)    DEFAULT NULL , 
      password varchar  (255)    DEFAULT NULL , 
      emissor_certificado varchar  (255)    DEFAULT NULL , 
      emissao_certificado timestamp(0)    DEFAULT NULL , 
      proprietario_certificado varchar  (255)    DEFAULT NULL , 
      validade_certificado timestamp(0)    DEFAULT NULL , 
      validar_certificado number(10)    DEFAULT 0 , 
      observacao varchar(3000)   , 
      info1 varchar  (100)    DEFAULT NULL , 
      info2 varchar  (255)    DEFAULT NULL , 
      info3 varchar  (255)    DEFAULT NULL , 
      info4 varchar  (255)    DEFAULT NULL , 
      info5 varchar  (255)    DEFAULT NULL , 
      mens1 varchar  (255)    DEFAULT NULL , 
      mens2 varchar  (255)    DEFAULT NULL , 
      mens3 varchar  (255)    DEFAULT NULL , 
      mens4 varchar  (255)    DEFAULT NULL , 
      token_api_local varchar(3000)   , 
      login_api varchar  (255)    DEFAULT NULL , 
      senha_api varchar  (255)    DEFAULT NULL , 
      chave_1 varchar(3000)   , 
      chave_2 varchar(3000)   , 
      chave_3 varchar(3000)   , 
      chave_4 varchar(3000)   , 
      api_endpoint_url_homologacao varchar(3000)   , 
      api_endpoint_url_producao varchar(3000)   , 
      client_secret varchar(3000)   , 
      status number(10)    DEFAULT 1 , 
      apelido varchar  (20)    DEFAULT NULL , 
      chave_pix varchar(3000)   , 
      tipo_chave_pix varchar  (50)    DEFAULT NULL , 
      client_id_bolecode varchar(3000)   , 
      client_secret_bolecode varchar(3000)   , 
      certificados_pix varchar  (255)    DEFAULT NULL , 
      certificados_extra varchar  (255)    DEFAULT NULL , 
      senha_certificado_pix varchar(3000)    DEFAULT NULL , 
      senha_certificado_extra varchar  (255)    DEFAULT NULL , 
      carteira varchar  (50)    DEFAULT NULL , 
      certificado_base64 varchar(3000)   , 
      certificado_pix_base64 varchar(3000)   , 
      certificado_extra_base64 varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE parametros_sicredi( 
      id number(10)    NOT NULL , 
      banco_id number(10)    NOT NULL , 
      beneficiario_id number(10)    NOT NULL , 
      system_unit_id number(10)    DEFAULT NULL , 
      numerocontrato varchar  (100)    NOT NULL , 
      numerocontacorrente varchar  (100)    NOT NULL , 
      modalidade number(10)   , 
      identificacaoboletoempresa number(10)    DEFAULT 0 , 
      identificacaoemissaoboleto varchar  (100)   , 
      identificacaodistribuicaoboleto varchar  (100)   , 
      tipodesconto varchar  (50)   , 
      diasparadesconto_primeiro number(10)    DEFAULT 1 , 
      valorprimeirodesconto binary_double   , 
      dataprimeirodesconto date   , 
      diasparadesconto_segundo number(10)   , 
      datasegundodesconto date   , 
      valorsegundodesconto binary_double   , 
      diasparadesconto_terceiro varchar  (255)   , 
      dataterceirodesconto date   , 
      valorTerceiroDesconto binary_double   , 
      tipomulta varchar  (50)    DEFAULT '0' , 
      tipojurosmora varchar  (50)    DEFAULT '0' , 
      diasmultas number(10)    DEFAULT 5 , 
      valormulta number(10)    DEFAULT 0 , 
      diasjurosmora number(10)    DEFAULT 0 , 
      valorjurosmora number(10)    DEFAULT 0 , 
      codigoprotesto varchar  (11)    DEFAULT '50' , 
      numerodiasprotesto number(10)    DEFAULT 0 , 
      codigonegativacao varchar  (50)    DEFAULT NULL , 
      numerodiasnegativacao number(10)    DEFAULT NULL , 
      gerarpdf varchar  (10)   , 
      ambiente number(10)    DEFAULT 2 , 
      client_id varchar  (255)    DEFAULT NULL , 
      apelido varchar  (20)    DEFAULT NULL , 
      carteira varchar  (50)    DEFAULT NULL , 
      certificado_base64 varchar(3000)   , 
      agencia number(10)    DEFAULT 6789 , 
      digito_agencia number(10)    DEFAULT 3 , 
      digito_conta varchar  (10)   , 
      username varchar  (200)   , 
      password varchar  (255)   , 
      scope varchar(3000)   , 
      info1 varchar  (80)   , 
      info2 varchar  (80)   , 
      info3 varchar  (80)   , 
      info4 varchar  (80)   , 
      info5 varchar  (80)   , 
      mens1 varchar  (80)   , 
      mens2 varchar  (80)   , 
      mens3 varchar  (80)   , 
      mens4 varchar  (80)   , 
      cooperativa varchar  (10)   , 
      posto varchar  (10)   , 
      status number(10)  (11)   , 
      codigobeneficiario varchar  (20)   , 
      cpfcnpjbeneficiario varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE rateio_sicoob( 
      id number(10)    NOT NULL , 
      parametros_bancos_id number(10)    NOT NULL , 
      numerobanco number(10)   , 
      numeroagencia number(10)   , 
      numerocontacorrente bigint   , 
      contaprincipal number(10)   , 
      codigotipovalorrateio number(10)   , 
      valorrateio binary_double  (10,2)   , 
      codigotipocalculorateio number(10)   , 
      numerocpfcnpjtitular bigint   , 
      nometitular varchar  (255)   , 
      codigofinalidadeted number(10)   , 
      codigotipocontadestinoted varchar  (2)   , 
      quantidadediasfloat number(10)   , 
      datafloatcredito date   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE situacao_boleto( 
      id number(10)    NOT NULL , 
      nome varchar  (20)   , 
      cor varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_cobranca( 
      codigoBeneficiario varchar  (255)    NOT NULL , 
      dia date    NOT NULL , 
      cpfCnpjBeneficiario varchar  (14)    NOT NULL , 
      status varchar  (50)    NOT NULL , 
      parametros_bancos_id number(10)  (11)   , 
      id number(10)    NOT NULL , 
      banco_id number(10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document( 
      id number(10)    NOT NULL , 
      category_id number(10)    NOT NULL , 
      system_user_id number(10)   , 
      title varchar(3000)    NOT NULL , 
      description varchar(3000)   , 
      submission_date date   , 
      archive_date date   , 
      filename varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_category( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_group( 
      id number(10)    NOT NULL , 
      document_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_user( 
      id number(10)    NOT NULL , 
      document_id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_message( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_user_to_id number(10)    NOT NULL , 
      subject varchar(3000)    NOT NULL , 
      message varchar(3000)   , 
      dt_message timestamp(0)   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_notification( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_user_to_id number(10)    NOT NULL , 
      subject varchar(3000)   , 
      message varchar(3000)   , 
      dt_message timestamp(0)   , 
      action_url varchar(3000)   , 
      action_label varchar(3000)   , 
      icon varchar(3000)   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)    NOT NULL , 
      preference varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      controller varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      connection_name varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      login varchar(3000)    NOT NULL , 
      password varchar(3000)    NOT NULL , 
      email varchar(3000)   , 
      frontpage_id number(10)   , 
      system_unit_id number(10)   , 
      active char  (1)   , 
      accepted_term_policy_at varchar(3000)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipos_generico( 
      id number(10)    NOT NULL , 
      chave_numerica varchar  (50)   , 
      titulo varchar  (50)    DEFAULT NULL , 
      descricao varchar  (255)    DEFAULT NULL , 
      chave varchar  (255)    DEFAULT NULL , 
      bancos_modulos_id number(10)  (11)    DEFAULT NULL , 
      app varchar  (50)    DEFAULT NULL , 
      status number(10)  (11)    DEFAULT 1 , 
 PRIMARY KEY (id)) ; 

CREATE TABLE workspaces_santander( 
      id number(10)    NOT NULL , 
      status varchar  (10)    NOT NULL , 
      type varchar  (10)    NOT NULL , 
      description varchar  (255)    NOT NULL , 
      covenant_code varchar  (36)    NOT NULL , 
      bank_slip_billing_webhook_active char(1)   , 
      pix_billing_webhook_active char(1)   , 
      parametros_bancos_id number(10)    NOT NULL , 
      id_remoto varchar  (255)   , 
      webhookurl varchar(3000)   , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE banco ADD CONSTRAINT fk_banco_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE beneficiario ADD CONSTRAINT fk_beneficiario_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE cliente ADD CONSTRAINT fk_cliente_1 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE cobranca_titulo ADD CONSTRAINT fk_cobranca_titulo_1 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE cobranca_titulo ADD CONSTRAINT fk_cobranca_titulo_2 FOREIGN KEY (cliente_id) references cliente(id); 
ALTER TABLE cobranca_titulo ADD CONSTRAINT fk_cobranca_titulo_3 FOREIGN KEY (parametros_bancos_id) references parametros_bancos(id); 
ALTER TABLE cobranca_titulo ADD CONSTRAINT fk_cobranca_titulo_4 FOREIGN KEY (status) references situacao_boleto(id); 
ALTER TABLE controle_meu_numeros ADD CONSTRAINT fk_controle_meu_numeros_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE layout_bancos ADD CONSTRAINT fk_layout_bancos_1 FOREIGN KEY (bancos_modulos_id) references banco(id); 
ALTER TABLE manual_integracao ADD CONSTRAINT fk_manual_integracao_1 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE parametros_bancos ADD CONSTRAINT fk_parametros_bancos_3 FOREIGN KEY (workspaces_santander_id) references workspaces_santander(id); 
ALTER TABLE parametros_bancos ADD CONSTRAINT fk_parametros_sicred_2_6928565d9f669ce755 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE parametros_bancos ADD CONSTRAINT fk_parametros_sicred_1_6928565d9f669ce755 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE parametros_itau ADD CONSTRAINT fk_parametros_itau_2 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE parametros_itau ADD CONSTRAINT fk_parametros_itau_2 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE parametros_sicredi ADD CONSTRAINT fk_parametros_sicred_1 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE parametros_sicredi ADD CONSTRAINT fk_parametros_sicred_2 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE rateio_sicoob ADD CONSTRAINT fk_rateio_sicoob_1 FOREIGN KEY (parametros_bancos_id) references parametros_bancos(id); 
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_2 FOREIGN KEY (category_id) references system_document_category(id); 
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_2 FOREIGN KEY (document_id) references system_document(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_2 FOREIGN KEY (document_id) references system_document(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_2 FOREIGN KEY (system_user_to_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_2 FOREIGN KEY (system_user_to_id) references system_users(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY (frontpage_id) references system_program(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE workspaces_santander ADD CONSTRAINT fk_workspaces_santander_1 FOREIGN KEY (parametros_bancos_id) references parametros_bancos(id); 
 CREATE SEQUENCE banco_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER banco_id_seq_tr 

BEFORE INSERT ON banco FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT banco_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE bancos_modulos_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER bancos_modulos_id_seq_tr 

BEFORE INSERT ON bancos_modulos FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT bancos_modulos_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE beneficiario_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER beneficiario_id_seq_tr 

BEFORE INSERT ON beneficiario FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT beneficiario_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE boleto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER boleto_id_seq_tr 

BEFORE INSERT ON boleto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT boleto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cliente_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cliente_id_seq_tr 

BEFORE INSERT ON cliente FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT cliente_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cobranca_titulo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cobranca_titulo_id_seq_tr 

BEFORE INSERT ON cobranca_titulo FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT cobranca_titulo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE controle_meu_numeros_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER controle_meu_numeros_id_seq_tr 

BEFORE INSERT ON controle_meu_numeros FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT controle_meu_numeros_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE eventos_boletos_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER eventos_boletos_id_seq_tr 

BEFORE INSERT ON eventos_boletos FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT eventos_boletos_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE layout_bancos_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER layout_bancos_id_seq_tr 

BEFORE INSERT ON layout_bancos FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT layout_bancos_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE manual_integracao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER manual_integracao_id_seq_tr 

BEFORE INSERT ON manual_integracao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT manual_integracao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE paises_codigos_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER paises_codigos_id_seq_tr 

BEFORE INSERT ON paises_codigos FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT paises_codigos_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE parametros_bancos_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER parametros_bancos_id_seq_tr 

BEFORE INSERT ON parametros_bancos FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT parametros_bancos_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE parametros_itau_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER parametros_itau_id_seq_tr 

BEFORE INSERT ON parametros_itau FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT parametros_itau_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE parametros_sicredi_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER parametros_sicredi_id_seq_tr 

BEFORE INSERT ON parametros_sicredi FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT parametros_sicredi_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE rateio_sicoob_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER rateio_sicoob_id_seq_tr 

BEFORE INSERT ON rateio_sicoob FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT rateio_sicoob_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE situacao_boleto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER situacao_boleto_id_seq_tr 

BEFORE INSERT ON situacao_boleto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT situacao_boleto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE status_cobranca_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER status_cobranca_id_seq_tr 

BEFORE INSERT ON status_cobranca FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT status_cobranca_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipos_generico_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipos_generico_id_seq_tr 

BEFORE INSERT ON tipos_generico FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipos_generico_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE workspaces_santander_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER workspaces_santander_id_seq_tr 

BEFORE INSERT ON workspaces_santander FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT workspaces_santander_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 