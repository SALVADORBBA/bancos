INSERT INTO system_group (id, name, uuid) VALUES( (SELECT max(g.id) + 1 FROM system_group g) , 'Bancos', '044db963-5de3-404d-8fe4-56d1d94e1760');
INSERT INTO system_user_group (id, system_group_id, system_user_id) VALUES((SELECT max(ug.id) + 1 FROM system_user_group ug), (SELECT max(g.id) FROM system_group g), 1);
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos BANRISUL', 'ParametrosBancosBanrisulForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosBanrisulForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos BB', 'ParametrosBancosBBForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosBBForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos itau', 'ParametrosBancosItauForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosItauForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de situacao boleto', 'SituacaoBoletoForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'SituacaoBoletoForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Baixar', 'Baixar');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'Baixar'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de cobranca Sicred', 'CobrancaTituloSicrediForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'CobrancaTituloSicrediForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de cobranca Itau', 'CobrancaTituloItauForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'CobrancaTituloItauForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos(Clonado)', 'ParametrosBancosFormClonado');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosFormClonado'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos', 'ParametrosBancosSicrediForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosSicrediForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos Sicoob', 'ParametrosBancosSicoobForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosSicoobForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos Santader', 'ParametrosBancosSantaderForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosSantaderForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos Bradesco', 'ParametrosBancosBradescoForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosBradescoForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de parametros bancos CEF', 'ParametrosBancosCEFForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosCEFForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cobranca titulos', 'CobrancaTituloList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'CobrancaTituloList'));
INSERT INTO system_group (id, name, uuid) VALUES( (SELECT max(g.id) + 1 FROM system_group g) , 'Básico', 'ece58b23-1bd4-4d0c-975c-eeb8bb6f0cfe');
INSERT INTO system_user_group (id, system_group_id, system_user_id) VALUES((SELECT max(ug.id) + 1 FROM system_user_group ug), (SELECT max(g.id) FROM system_group g), 1);
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'TesteControlle', 'TesteControlle');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'TesteControlle'));
INSERT INTO system_group (id, name, uuid) VALUES( (SELECT max(g.id) + 1 FROM system_group g) , 'Cadastros', 'cbfd80ba-7089-4f1c-a8b3-88617a9de6e8');
INSERT INTO system_user_group (id, system_group_id, system_user_id) VALUES((SELECT max(ug.id) + 1 FROM system_user_group ug), (SELECT max(g.id) FROM system_group g), 1);
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Beneficiarios', 'BeneficiarioList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'BeneficiarioList'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Clientes', 'ClienteList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ClienteList'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de cliente', 'ClienteForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ClienteForm'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de beneficiario', 'BeneficiarioForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'BeneficiarioForm'));
INSERT INTO system_group (id, name, uuid) VALUES( (SELECT max(g.id) + 1 FROM system_group g) , 'Cobranças(Titulos)', 'ea98cbc6-657d-4916-a8c0-b8cb16b8fb0c');
INSERT INTO system_user_group (id, system_group_id, system_user_id) VALUES((SELECT max(ug.id) + 1 FROM system_user_group ug), (SELECT max(g.id) FROM system_group g), 1);
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'AlterarVencimento', 'AlterarVencimentoForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'AlterarVencimentoForm'));
INSERT INTO system_group (id, name, uuid) VALUES( (SELECT max(g.id) + 1 FROM system_group g) , 'Configuração', '02879fa0-fbd7-4d28-baf5-92a259ec8f2d');
INSERT INTO system_user_group (id, system_group_id, system_user_id) VALUES((SELECT max(ug.id) + 1 FROM system_user_group ug), (SELECT max(g.id) FROM system_group g), 1);
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de  layout bancos', 'LayoutBancosForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'LayoutBancosForm'));
INSERT INTO system_group (id, name, uuid) VALUES( (SELECT max(g.id) + 1 FROM system_group g) , 'Configurações', 'e6dc5e7e-6e05-447a-9798-fbb99d78243a');
INSERT INTO system_user_group (id, system_group_id, system_user_id) VALUES((SELECT max(ug.id) + 1 FROM system_user_group ug), (SELECT max(g.id) FROM system_group g), 1);
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Controle meu numeross', 'ControleMeuNumerosList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ControleMeuNumerosList'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Layout Bancos', 'LayoutBancosList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'LayoutBancosList'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Bancos', 'BancoList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'BancoList'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Situacao boletos', 'SituacaoBoletoList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'SituacaoBoletoList'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Workspaces santanders', 'WorkspacesSantanderList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'WorkspacesSantanderList'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Controle MeuNumeros FormSicredi', 'ControleMeuNumerosFormSicredi');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ControleMeuNumerosFormSicredi'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de workspaces santander', 'WorkspacesSantanderForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'WorkspacesSantanderForm'));
INSERT INTO system_group (id, name, uuid) VALUES( (SELECT max(g.id) + 1 FROM system_group g) , 'Parâmetros Bancos', '5734e95c-59a6-47aa-aa89-7cd5f5451199');
INSERT INTO system_user_group (id, system_group_id, system_user_id) VALUES((SELECT max(ug.id) + 1 FROM system_user_group ug), (SELECT max(g.id) FROM system_group g), 1);
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Parametros bancoss', 'ParametrosBancosList');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'ParametrosBancosList'));
INSERT INTO system_program (id,name,controller) VALUES( (SELECT max(p.id) + 1 FROM system_program p) , 'Cadastro de banco', 'BancoForm');
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES( (SELECT max(gp.id) + 1 FROM system_group_program gp), (SELECT max(g.id) FROM system_group g) , (SELECT max(p.id) FROM system_program p where p.controller = 'BancoForm'));